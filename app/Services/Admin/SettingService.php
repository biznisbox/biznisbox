<?php

namespace App\Services\Admin;

use App\Models\Setting;
use App\Helpers\SerialNumberFormatter;
use Illuminate\Support\Facades\Storage;
use App\Mail\Admin\TestEmail;
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
        createActivityLog('retrieve', null, Setting::$modelName, 'getCompanySettings');
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
        createActivityLog('update', null, Setting::$modelName, 'updateCompanySettings');
        return true;
    }

    public function setCompanyLogo($request)
    {
        if ($request->hasFile('company_logo')) {
            $company_logo = settings('company_logo');
            if ($company_logo) {
                Storage::disk('public')->delete($company_logo);
            }
            $file = $request->file('company_logo');
            $filename = $file->hashName();
            Storage::disk('public')->put($filename, file_get_contents($file));
            settings(['company_logo' => $filename], 'set');
            createActivityLog('update', null, Setting::$modelName, 'setCompanyLogo');

            return true;
        }
    }

    public function removeCompanyLogo()
    {
        $company_logo = settings('company_logo');
        if ($company_logo) {
            Storage::disk('public')->delete($company_logo);
        }
        settings(['company_logo' => null], 'set');

        createActivityLog('update', null, Setting::$modelName, 'removeCompanyLogo');

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
        createActivityLog('retrieve', null, Setting::$modelName, 'getSettings');
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
        createActivityLog('update', null, Setting::$modelName, 'updateSettings');
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
        createActivityLog('retrieve', null, Setting::$modelName, 'getNumberingSettings');
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
        createActivityLog('update', null, Setting::$modelName, 'updateNumberingSettings');
        return true;
    }

    public function generatePreviewNumber($format, $module)
    {
        if (!$format || !$module) {
            return '...';
        }
        $numberFormatter = new SerialNumberFormatter();
        return $numberFormatter->generatePreview($format, $module);
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
        $settings = Setting::where('key', 'like', 'mail_%')->get();
        $data = [];
        foreach ($settings as $setting) {
            $data[$setting->key] = $setting->value;
        }
        createActivityLog('retrieve', null, Setting::$modelName, 'getEmailSettings');
        return $data;
    }

    /**
     * Update email settings
     * @param array $data - Email settings data
     * @return null - return null
     */
    public function updateEmailSettings($data)
    {
        settings($data, 'set');
        createActivityLog('update', null, Setting::$modelName, 'updateEmailSettings');
        return true;
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
