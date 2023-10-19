<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\SettingsService;

class SettingsController extends Controller
{
    protected $settingsService;
    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    public function getCompanySettings()
    {
        return $this->settingsService->getCompanySettings();
    }

    public function updateCompanySettings(Request $request)
    {
        return $this->settingsService->updateCompanySettings($request->all());
    }

    public function getSettings()
    {
        return $this->settingsService->getSettings();
    }

    public function updateSettings(Request $request)
    {
        return $this->settingsService->updateSettings($request->all());
    }

    // Currency Settings
    public function getCurrencies()
    {
        return $this->settingsService->getCurrencies();
    }

    public function getCurrency($id)
    {
        return $this->settingsService->getCurrency($id);
    }

    public function createCurrency(Request $request)
    {
        return $this->settingsService->createCurrency($request->all());
    }

    public function updateCurrency(Request $request, $id)
    {
        return $this->settingsService->updateCurrency($id, $request->all());
    }

    public function deleteCurrency($id)
    {
        return $this->settingsService->deleteCurrency($id);
    }

    public function liveUpdateCurrencyRate()
    {
        return $this->settingsService->liveUpdateCurrencyRate();
    }

    // Tax Settings
    public function getTaxes()
    {
        return $this->settingsService->getTaxes();
    }

    public function getTax($id)
    {
        return $this->settingsService->getTax($id);
    }

    public function createTax(Request $request)
    {
        return $this->settingsService->createTax($request->all());
    }

    public function updateTax(Request $request, $id)
    {
        return $this->settingsService->updateTax($id, $request->all());
    }

    public function deleteTax($id)
    {
        return $this->settingsService->deleteTax($id);
    }

    // Company Logo
    public function saveCompanyImage(Request $request)
    {
        return $this->settingsService->saveCompanyImage($request);
    }

    public function removeCompanyImage()
    {
        return $this->settingsService->removeCompanyImage();
    }

    public function checkVersion()
    {
        return $this->settingsService->checkVersion();
    }

    public function checkServerStatus()
    {
        return $this->settingsService->checkServerStatus();
    }
}
