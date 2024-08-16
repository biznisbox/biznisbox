<?php

namespace App\Services\Admin;

use App\Models\Setting;
use App\Helpers\SerialNumberFormatter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Mail\Admin\TestEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SettingService
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
        $settings = Setting::where('key', 'like', 'company_%')->get();
        $data = [];
        foreach ($settings as $setting) {
            $data[$setting->key] = $setting->value;
        }
        createActivityLog('retrieve', null, 'App\Models\Setting', 'getCompanySettings');
        return $data;
    }

    /**
     * Update company settings
     * @param array $data - Company settings data
     * @return null - return null
     */

    public function updateCompanySettings($data)
    {
        settings($data, 'set');
        createActivityLog('update', null, 'App\Models\Setting', 'Setting');
        return true;
    }

    public function setCompanyLogo($request)
    {
        if ($request->hasFile('company_logo')) {
            $company_logo = settings('company_logo');
            if ($company_logo) {
                $path = storage_path('public/' . $company_logo);
                Storage::delete($path);
            }
            $file = $request->file('company_logo');
            $filename = $file->hashName();
            $file->storeAs('public', $filename);
            settings(['company_logo' => $filename], 'set');

            createActivityLog('update', null, 'App\Models\Setting', 'setCompanyLogo');

            return true;
        }
    }

    public function removeCompanyLogo()
    {
        $company_logo = settings('company_logo');
        if ($company_logo) {
            $path = storage_path('public/' . $company_logo);
            Storage::delete($path);
        }
        settings(['company_logo' => null], 'set');

        createActivityLog('update', null, 'App\Models\Setting', 'removeCompanyLogo');

        return true;
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
        $settings = Setting::all();
        $data = [];
        foreach ($settings as $setting) {
            $data[$setting->key] = $setting->value;
        }
        createActivityLog('retrieve', null, 'App\Models\Setting', 'getSettings');
        return $data;
    }

    /**
     * Update settings
     * @param array $data - Settings data
     * @return null - return null
     */
    public function updateSettings($data)
    {
        settings($data, 'set');
        createActivityLog('update', null, 'App\Models\Setting', 'updateSettings');
        return true;
    }

    /*=============================================
    =            Serial Number Settings           =
    =============================================*/

    /**
     * Get serial number settings
     * @return settings - return settings object
     */

    public function getNumberingSettings()
    {
        $settings = Setting::where('key', 'like', '%_number_format')->get();
        $data = [];
        foreach ($settings as $setting) {
            $data[$setting->key] = SerialNumberFormatter::convertNumberFormatToArray($setting->value);
        }
        createActivityLog('retrieve', null, 'App\Models\Setting', 'getNumberingSettings');
        return $data;
    }

    /**
     * Update serial number settings
     * @param array $data - Serial number settings data
     * @return null - return null
     */
    public function updateNumberingSettings($data)
    {
        foreach ($data as $key => $value) {
            $value = SerialNumberFormatter::convertNumberFormatToString($value);
            settings([$key => $value], 'set');
        }
        createActivityLog('update', null, 'App\Models\Setting', 'updateNumberingSettings');
        return true;
    }

    public function generatePreviewNumber($format, $module)
    {
        if (!$format || !$module) {
            return '...';
        }
        $numberFormatter = new SerialNumberFormatter();
        $number = $numberFormatter->generatePreview($format, $module);
        return $number;
    }

    /*=============================================
    =               Mail Settings                 =
    =============================================*/

    /**
     * Get email settings
     * @return array - return email settings
     */
    public function getEmailSettings()
    {
        $env_settings = readFromEnvFile();
        $data = [];

        $env_settings = array_filter(
            $env_settings,
            function ($key) {
                return strpos($key, 'MAIL_') !== false;
            },
            ARRAY_FILTER_USE_KEY
        );

        foreach ($env_settings as $key => $value) {
            $data[Str::lower($key)] = $value == 'null' ? null : $value;
        }
        return $data;
    }

    /**
     * Update email settings
     * @param array $data - Email settings data
     * @return null - return null
     */
    public function updateEmailSettings($data)
    {
        $email_write = writeInEnvFile($data);
        if ($email_write) {
            createActivityLog('update', null, 'App\Models\Setting', 'updateEmailSettings');
            return true;
        }
        return false;
    }

    public function sentTestEmail($emails)
    {
        foreach ($emails as $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                Mail::to($email)->send(new TestEmail());
            }
        }
        return true;
    }
}
