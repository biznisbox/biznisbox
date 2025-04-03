<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\CurrencyService;

/**
 * @group Currencies
 *
 * APIs for managing currencies
 * @authenticated
 */
class CurrencyController extends Controller
{
    private $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    /**
     * Get all currencies
     *
     * @return array $currencies All currencies
     */
    public function getCurrencies()
    {
        $currencies = $this->currencyService->getCurrencies();
        if (!$currencies) {
            return api_response($currencies, __('responses.item_not_found'), 404);
        }
        return api_response($currencies, __('responses.data_retrieved_successfully'), 200);
    }

    /**
     * Get currency by id
     *
     * @param  string  $id id of the currency
     * @return array $currency currency
     */
    public function getCurrency($id)
    {
        $currency = $this->currencyService->getCurrency($id);
        if (!$currency) {
            return api_response($currency, __('responses.item_not_found_with_id'), 404);
        }
        return api_response($currency, __('responses.data_retrieved_successfully'), 200);
    }

    /**
     * Live update currency rate
     *
     * @return array $currency currency
     */
    public function liveUpdateCurrencyRate()
    {
        $currency = $this->currencyService->liveUpdateCurrencyRate();
        if (!$currency) {
            return api_response($currency, __('responses.currency_rate_not_updated'), 404);
        }
        return api_response($currency, __('responses.data_updated_successfully'), 200);
    }

    /**
     * Create a new currency
     *
     * @param  object  $request data from the form (name, code, symbol, rate)
     * @return array $currency currency
     */
    public function createCurrency(Request $request)
    {
        $data = $request->all();
        $currency = $this->currencyService->createCurrency($data);
        if (!$currency) {
            return api_response($currency, __('responses.item_not_found'), 404);
        }
        return api_response($currency, __('responses.item_created_successfully'), 200);
    }

    /**
     * Update currency
     *
     * @param  object  $request data from the form (name, code, symbol, rate)
     * @param  string  $id id of the currency
     * @return array $currency currency
     */
    public function updateCurrency(Request $request, $id)
    {
        $data = $request->all();
        $currency = $this->currencyService->updateCurrency($id, $data);
        if (!$currency) {
            return api_response($currency, __('responses.item_not_found'), 404);
        }
        return api_response($currency, __('responses.item_updated_successfully'), 200);
    }

    /**
     * Delete currency
     *
     * @param  string  $id id of the currency
     * @return array $currency currency
     */
    public function deleteCurrency($id)
    {
        $currency = $this->currencyService->deleteCurrency($id);
        if (!$currency) {
            return api_response($currency, __('responses.item_not_found'), 404);
        }
        return api_response($currency, __('responses.item_deleted_successfully'), 200);
    }
}
