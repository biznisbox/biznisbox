<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\SettingService;

class SettingController extends Controller
{
    protected $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function getCompanySettings()
    {
        $settings = $this->settingService->getCompanySettings();
        if (!$settings) {
            return api_response($settings, __('responses.item_not_found'), 404);
        }
        return api_response($settings, __('responses.data_retrieved_successfully'), 200);
    }

    public function updateCompanySettings(Request $request)
    {
        $settings = $this->settingService->updateCompanySettings($request->all());
        if (!$settings) {
            return api_response($settings, __('responses.item_not_updated'), 400);
        }
        return api_response($settings, __('responses.item_updated_successfully'), 200);
    }

    public function setCompanyLogo(Request $request)
    {
        $settings = $this->settingService->setCompanyLogo($request);
        if (!$settings) {
            return api_response($settings, __('responses.item_not_updated'), 400);
        }
        return api_response($settings, __('responses.item_updated_successfully'), 200);
    }

    public function removeCompanyLogo()
    {
        $settings = $this->settingService->removeCompanyLogo();
        if (!$settings) {
            return api_response($settings, __('responses.item_not_deleted'), 400);
        }
        return api_response($settings, __('responses.item_deleted_successfully'), 200);
    }

    public function getSettings()
    {
        $settings = $this->settingService->getSettings();
        if (!$settings) {
            return api_response($settings, __('responses.item_not_found'), 404);
        }
        return api_response($settings, __('responses.data_retrieved_successfully'), 200);
    }

    public function updateSettings(Request $request)
    {
        $settings = $this->settingService->updateSettings($request->all());
        if (!$settings) {
            return api_response($settings, __('responses.item_not_updated'), 400);
        }
        return api_response($settings, __('responses.item_updated_successfully'), 200);
    }

    public function getNumberingSettings()
    {
        $settings = $this->settingService->getNumberingSettings();
        if (!$settings) {
            return api_response($settings, __('responses.item_not_found'), 404);
        }
        return api_response($settings, __('responses.data_retrieved_successfully'), 200);
    }

    public function updateNumberingSettings(Request $request)
    {
        $settings = $this->settingService->updateNumberingSettings($request->all());
        if (!$settings) {
            return api_response($settings, __('responses.item_not_updated'), 400);
        }
        return api_response($settings, __('responses.item_updated_successfully'), 200);
    }

    public function generatePreviewNumber(Request $request)
    {
        $format = $request->format;
        $module = $request->module;
        $number = $this->settingService->generatePreviewNumber($format, $module);
        if (!$number) {
            return api_response($number, __('responses.item_not_found'), 404);
        }
        return api_response($number, __('responses.data_retrieved_successfully'), 200);
    }

    public function getEmailSettings()
    {
        $settings = $this->settingService->getEmailSettings();
        if (!$settings) {
            return api_response($settings, __('responses.item_not_found'), 404);
        }
        return api_response($settings, __('responses.data_retrieved_successfully'), 200);
    }

    public function updateEmailSettings(Request $request)
    {
        $settings = $this->settingService->updateEmailSettings($request->all());
        if (!$settings) {
            return api_response($settings, __('responses.item_not_updated'), 400);
        }
        return api_response($settings, __('responses.item_updated_successfully'), 200);
    }

    public function sentTestEmail(Request $request)
    {
        $emails = $request->emails;
        $settings = $this->settingService->sentTestEmail($emails);
        if (!$settings) {
            return api_response($settings, __('responses.email_not_sent'), 400);
        }
        return api_response($settings, __('responses.email_sent'), 200);
    }
}
