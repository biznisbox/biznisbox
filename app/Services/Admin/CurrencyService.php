<?php

namespace App\Services\Admin;

use App\Models\Currency;

class CurrencyService
{
    private $currency;
    public function __construct()
    {
        $this->currency = new Currency();
    }

    public function getCurrencies()
    {
        $currencies = $this->currency->all();
        createActivityLog('retrieve', null, 'App\Models\Currency', 'getCurrencies');
        return $currencies;
    }

    public function getCurrency($id)
    {
        $currency = $this->currency->where('id', $id)->first();
        createActivityLog('retrieve', $id, 'App\Models\Currency', 'getCurrency');
        return $currency;
    }

    public function liveUpdateCurrencyRate()
    {
        $currency = new Currency();
        return $currency->liveUpdateCurrencyRate();
    }

    public function createCurrency($data)
    {
        $currency = $this->currency->create($data);
        return $currency;
    }

    public function updateCurrency($id, $data)
    {
        $currency = $this->currency->find($id);
        if (!$currency) {
            return false;
        }
        $currency->update($data);
        return $currency;
    }

    public function deleteCurrency($id)
    {
        $currency = $this->currency->find($id);
        if (!$currency || $currency->code == settings('default_currency')) {
            return false;
        }
        $currency->delete();
        return $currency;
    }

    public function getCurrencyRate($from, $to)
    {
        $currency = $this->currency->where('code', $from)->first();
        if (!$currency) {
            return false;
        }
        if ($from == $to) {
            return 1;
        }
        return $currency->exchange_rate;
    }
}
