<?php

namespace App\Services\Admin;

use App\Models\Accounts;
use App\Models\Settings;
use App\Models\Currencies;
use App\Models\Taxes;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

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

        // Activate Stripe and Paypal accounts if they are available and have keys
        if ($data['stripe_available'] && $data['stripe_key'] && $data['stripe_account_id']) {
            Accounts::find($data['stripe_account_id'])->update(['is_active' => 1]);
        }

        if ($data['paypal_available'] && $data['paypal_client_id'] && $data['paypal_secret']) {
            Accounts::find($data['paypal_account_id'])->update(['is_active' => 1]);
        }
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
        return api_response($tax, __('response.admin.taxes.create_success'));
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
        if (settings('company_logo') != '/biznisbox_logo.png') {
            File::delete(public_path(settings('company_logo')));
            settings(['company_logo' => '/biznisbox_logo.png']);
        }
        return api_response(null, __('response.admin.company_logo.remove_success'));
    }

    /**
     * Get current version of the app from composer.json file used for getting the version
     */
    public function getVersionInternal()
    {
        if (file_exists(base_path('composer.json'))) {
            $composer = json_decode(file_get_contents(base_path('composer.json')));
            $version = $composer->version;
            return $version;
        }
    }

    /**
     * Check if there is a new version of the app
     */
    public function checkVersion()
    {
        $github_latest_release = Http::get('https://api.github.com/repos/biznisbox/biznisbox/releases/latest');
        $current_version = $this->getVersionInternal();
        if ($github_latest_release) {
            $github_latest_release = json_decode($github_latest_release);
            $github_latest_release = $github_latest_release->tag_name;
            if ($current_version != $github_latest_release) {
                return api_response(['version' => $current_version, 'latest_version' => $github_latest_release], __('update_available'));
            } else {
                return api_response(['version' => $current_version, 'latest_version' => $github_latest_release], __('no_update'));
            }
        } else {
            return api_response(['version' => $current_version, 'latest_version' => $this->getVersionInternal()], __('no_update'));
        }
    }

    /**
     * Check server status
     */
    public function checkServerStatus()
    {
        $disk_available = disk_free_space(base_path());
        $disk_total = disk_total_space(base_path());
        $disk_used = $disk_total - $disk_available;
        $disk_percentage = round(($disk_used / $disk_total) * 100, 2);

        $memory_total = memory_get_usage(true);
        $memory_used = memory_get_usage(false);
        $memory_percentage = round(($memory_used / $memory_total) * 100, 2);

        $server_os = PHP_OS_FAMILY;
        $hostname = gethostname();

        $disk_graph = [
            'labels' => [__('response.disk_used'), __('response.disk_available')],
            'datasets' => [
                [
                    'data' => [$disk_used, $disk_available],
                    'backgroundColor' => ['#f44336', '#4caf50'],
                    'hoverBackgroundColor' => ['#f44336', '#4caf50'],
                ],
            ],
        ];

        $memory_graph = [
            'labels' => [__('response.memory_used'), __('response.memory_available')],
            'datasets' => [
                [
                    'data' => [$memory_used, $memory_total],
                    'backgroundColor' => ['#f44336', '#4caf50'],
                    'hoverBackgroundColor' => ['#f44336', '#4caf50'],
                ],
            ],
        ];

        return api_response(
            [
                'disk_available' => $disk_available,
                'disk_total' => $disk_total,
                'disk_used' => $disk_used,
                'disk_graph' => $disk_graph,
                'disk_percentage' => $disk_percentage,
                'memory_total' => $memory_total,
                'memory_used' => $memory_used,
                'memory_percentage' => $memory_percentage,
                'memory_graph' => $memory_graph,
                'server_os' => $server_os,
                'hostname' => $hostname,
            ],
            __('response.admin.server_status')
        );
    }
}
