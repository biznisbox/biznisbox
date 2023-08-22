<?php

namespace App\Services\Admin;

use App\Models\Settings;
use App\Models\Currencies;
use App\Models\Taxes;
use Illuminate\Support\Facades\File;

class SettingsService
{
    /*=============================================
    =            Company Settings                 =
    =============================================*/

    /**
     * Get company settings
     * @return settings - return settings object
     */
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

    /**
     * Update company settings
     * @param array $data - Company settings data
     * @return null - return null
     */

    public function updateCompanySettings($data)
    {
        settings($data);
        activity_log(user_data()->data->id, 'update company settings', null, 'App\Models\Settings', 'updateCompanySettings');
        return api_response(null, __('response.admin.settings.update_success'));
    }

    /*=============================================
    =            General Settings                 =
    =============================================*/

    /**
     * Get settings
     * @return settings - return settings object
     */
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

    /**
     * Update settings
     * @param array $data - Settings data
     * @return null - return null
     */
    public function updateSettings($data)
    {
        settings($data);
        activity_log(user_data()->data->id, 'update settings', null, 'App\Models\Settings', 'updateSettings');
        return api_response(null, __('response.admin.settings.update_success'));
    }

    /*=============================================
    =            Currency Settings                =
    =============================================*/

    /**
     * Get currencies
     * @return currencies - return currencies object
     */
    public function getCurrencies()
    {
        $currencies = new Currencies();
        $currencies = $currencies->getCurrencies();
        activity_log(user_data()->data->id, 'get currencies', null, 'App\Models\Currencies', 'getCurrencies');
        return api_response($currencies);
    }

    /**
     * Get currency
     * @param UUID $id - Currency ID
     * @return currency - return currency object
     */
    public function getCurrency($id)
    {
        $currency = Currencies::find($id);
        activity_log(user_data()->data->id, 'get currency', $id, 'App\Models\Currencies', 'getCurrency');
        return api_response($currency);
    }

    /**
     * Create currency
     * @param array $data - Currency data
     * @return currency - return currency object
     */

    public function createCurrency($data)
    {
        $currencies = new Currencies();
        $currency = $currencies->create($data);
        return api_response($currency, __('response.admin.currency.create_success'));
    }

    /**
     * Update currency
     * @param UUID $id - Currency ID
     * @param array $data - Currency data
     * @return null - return null
     */
    public function updateCurrency($id, $data)
    {
        $currencies = new Currencies();
        $currency = $currencies->find($id);
        $currency = $currency->update($data);
        return api_response($currency, __('response.admin.currency.update_success'));
    }

    /**
     * Delete currency
     * @param UUID $id - Currency ID
     * @return null - return null
     */
    public function deleteCurrency($id)
    {
        $currencies = new Currencies();
        $currency = $currencies->find($id);
        $currency->delete();
        return api_response(null, __('response.admin.currency.delete_success'));
    }

    /**
     * Live update currency rates - used for cron job (or manually)
     * @return null - return null
     */
    public function liveUpdateCurrencyRate()
    {
        $currencies = new Currencies();
        $currencies->liveUpdateCurrencyRate();
        return api_response(null, __('response.admin.currency.rates_updated'));
    }

    /*=============================================	
    =            Tax Settings                     =
    =============================================*/

    /*
     * Get taxes
     * @return $taxes - return taxes object
     */
    public function getTaxes()
    {
        $taxes = new Taxes();
        $taxes = $taxes->getTaxes();
        activity_log(user_data()->data->id, 'get taxes', null, 'App\Models\Taxes', 'getTaxes');
        return api_response($taxes);
    }

    /*
     * Get tax
     * @param UUID $id - Tax ID
     * @return $tax - return tax object
     */
    public function getTax($id)
    {
        $tax = Taxes::find($id);
        activity_log(user_data()->data->id, 'get tax', $id, 'App\Models\Taxes', 'getTax');
        return api_response($tax);
    }

    /*
     * Create tax
     * @param array $data - Tax data
     * @return $tax - return tax object
     */
    public function createTax($data)
    {
        $taxes = new Taxes();
        $tax = $taxes->create($data);
        return api_response($tax, __('response.admin.taxes.create_success0'));
    }

    /*
     * Update tax
     * @param UUID $id - Tax ID
     * @param array $data - Tax data
     * @return $tax - return tax object
     */
    public function updateTax($id, $data)
    {
        $taxes = new Taxes();
        $tax = $taxes->find($id);
        $tax->update($data);
        return api_response($tax, __('response.admin.taxes.update_success'));
    }

    /**
     * Delete tax
     * @param UUID $id - Tax ID
     * @return null - return null
     */
    public function deleteTax($id)
    {
        $taxes = new Taxes();
        $tax = $taxes->find($id);
        $tax->delete();
        return api_response(null, __('response.admin.taxes.delete_success'));
    }

    /**
     * Save company logo
     * @param Request $request - request object from controller
     * @return null - return null
     */
    public function saveCompanyImage($request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = $image->hashName();
            $image->storeAs('company', $image_name, 'public');
            settings(['company_logo' => '/uploads/company/' . $image_name]);
            return api_response(null, __('response.admin.company_logo.upload_success'));
        }
    }

    /**
     * Remove company logo
     * @return null - return null
     */
    public function removeCompanyImage()
    {
        settings(['company_logo' => '/biznisbox_logo.png']);
        File::delete(public_path(settings('company_logo')));
        return api_response(null, __('response.admin.company_logo.remove_success'));
    }
}
