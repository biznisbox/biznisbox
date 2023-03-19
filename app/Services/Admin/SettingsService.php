<?php

namespace App\Services\Admin;

use App\Models\Settings;
use App\Models\Currencies;
use App\Models\Taxes;

class SettingsService
{
    public function getCompanySettings()
    {
        $settings = Settings::where('key', 'like', 'company_%')->get();
        $data = [];
        foreach ($settings as $setting) {
            $data[$setting->key] = $setting->value;
        }
        activity_log(user_data()->data->id, 'get company settings', null, 'App\Models\Settings', 'getCompanySettings');
        return api_response($data);
    }

    public function updateCompanySettings($data)
    {
        settings($data);
        activity_log(user_data()->data->id, 'update company settings', null, 'App\Models\Settings', 'updateCompanySettings');
        return api_response(null, __('response.admin.settings.update_success'));
    }

    public function getSettings()
    {
        $settings = Settings::all();
        $data = [];
        foreach ($settings as $setting) {
            $data[$setting->key] = $setting->value;
        }
        activity_log(user_data()->data->id, 'get settings', null, 'App\Models\Settings', 'getSettings');
        return api_response($data);
    }

    public function updateSettings($data)
    {
        settings($data);
        activity_log(user_data()->data->id, 'update settings', null, 'App\Models\Settings', 'updateSettings');
        return api_response(null, __('response.admin.settings.update_success'));
    }

    // Currency Settings
    public function getCurrencies()
    {
        $currencies = new Currencies();
        $currencies = $currencies->getCurrencies();
        activity_log(user_data()->data->id, 'get currencies', null, 'App\Models\Currencies', 'getCurrencies');
        return api_response($currencies);
    }

    public function getCurrency($id)
    {
        $currency = Currencies::find($id);
        activity_log(user_data()->data->id, 'get currency', $id, 'App\Models\Currencies', 'getCurrency');
        return api_response($currency);
    }

    public function createCurrency($data)
    {
        $currencies = new Currencies();
        $currency = $currencies->create($data);
        return api_response($currency, __('response.admin.currency.create_success'));
    }

    public function updateCurrency($id, $data)
    {
        $currencies = new Currencies();
        $currency = $currencies->find($id);
        $currency->update($data);
        return api_response(null, __('response.admin.currency.update_success'));
    }

    public function deleteCurrency($id)
    {
        $currencies = new Currencies();
        $currency = $currencies->find($id);
        $currency->delete();
        return api_response(null, __('response.admin.currency.delete_success'));
    }

    public function liveUpdateCurrencyRate()
    {
        $currencies = new Currencies();
        $currencies->liveUpdateCurrencyRate();
        return api_response(null, __('response.admin.currency.rates_updated'));
    }

    // Tax Settings
    public function getTaxes()
    {
        $taxes = new Taxes();
        $taxes = $taxes->getTaxes();
        activity_log(user_data()->data->id, 'get taxes', null, 'App\Models\Taxes', 'getTaxes');
        return api_response($taxes);
    }

    public function getTax($id)
    {
        $tax = Taxes::find($id);
        activity_log(user_data()->data->id, 'get tax', $id, 'App\Models\Taxes', 'getTax');
        return api_response($tax);
    }

    public function createTax($data)
    {
        $taxes = new Taxes();
        $tax = $taxes->create($data);
        return api_response($tax, __('response.admin.taxes.create_success0'));
    }

    public function updateTax($id, $data)
    {
        $taxes = new Taxes();
        $tax = $taxes->find($id);
        $tax->update($data);
        return api_response(null, __('response.admin.taxes.update_success'));
    }

    public function deleteTax($id)
    {
        $taxes = new Taxes();
        $tax = $taxes->find($id);
        $tax->delete();
        return api_response(null, __('response.admin.taxes.delete_success'));
    }
}
