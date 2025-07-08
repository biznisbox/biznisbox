<?php

namespace App\Services\Admin;

use App\Models\Currency;
use App\Integrations\ExchangeRate;

class CurrencyService
{
    private $currencyModel;
    private $exchangeRateIntegration;
    public function __construct(Currency $currency, ExchangeRate $exchangeRateIntegration)
    {
        $this->currencyModel = $currency;
        $this->exchangeRateIntegration = $exchangeRateIntegration;
    }

    public function getCurrencies()
    {
        $currencies = $this->currencyModel->all();
        createActivityLog('retrieve', null, 'App\Models\Currency', 'getCurrencies');
        return $currencies;
    }

    public function getCurrency($id)
    {
        $currency = $this->currencyModel->where('id', $id)->first();
        createActivityLog('retrieve', $id, 'App\Models\Currency', 'getCurrency');
        return $currency;
    }

    public function liveUpdateCurrencyRate()
    {
        $exchangeRateProvider = settings('exchange_rate_provider');
        createActivityLog('updateCurrencyRate', null, 'App\Models\Currency', 'liveUpdateCurrencyRate');

        if ($exchangeRateProvider == 'ecb') {
            if (!settings('default_currency') == 'EUR') {
                return [
                    'message' => __('responses.default_currency_must_be_eur'),
                    'status' => false,
                ];
            }
            $currencies = $this->currencyModel->where('code', '!=', 'EUR')->get();
            foreach ($currencies as $currency) {
                $rate = $this->exchangeRateIntegration->getExchangeRateByECB($currency->code);
                if ($rate) {
                    $this->currencyModel->where('id', $currency->id)->update(['exchange_rate' => $rate]);
                }
            }
            return [
                'message' => __('responses.currency_rate_updated'),
                'status' => true,
            ];
        } elseif ($exchangeRateProvider == 'exchange-api') {
            $currencies = $this->currencyModel->all();
            foreach ($currencies as $currency) {
                $rate = $this->exchangeRateIntegration->getExchangeRateByCurrencyApi(settings('default_currency'), $currency->code);
                if ($rate) {
                    $this->currencyModel->where('id', $currency->id)->update(['exchange_rate' => $rate]);
                }
            }
            return [
                'message' => __('responses.currency_rate_updated'),
                'status' => true,
            ];
        } else {
            return [
                'message' => __('responses.invalid_exchange_rate_provider'),
                'status' => false,
            ];
        }
    }

    public function createCurrency($data)
    {
        $currency = $this->currencyModel->create($data);
        return $currency;
    }

    public function updateCurrency($id, $data)
    {
        $currency = $this->currencyModel->find($id);
        if (!$currency) {
            return false;
        }
        $currency->update($data);
        return $currency;
    }

    public function deleteCurrency($id)
    {
        $currency = $this->currencyModel->find($id);
        if (!$currency || $currency->code == settings('default_currency')) {
            return false;
        }
        $currency->delete();
        return $currency;
    }

    public function getCurrencyRate($from, $to)
    {
        $currency = $this->currencyModel->where('code', $from)->first();
        if (!$currency) {
            return false;
        }
        if ($from == $to) {
            return 1;
        }
        return $currency->exchange_rate;
    }
}
