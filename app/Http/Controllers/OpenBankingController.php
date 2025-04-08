<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OpenBankingService;

/**
 * @group Open Banking
 *
 * APIs for managing open banking
 * @authenticated
 */
class OpenBankingController extends Controller
{
    private OpenBankingService $openBankingService;

    public function __construct(OpenBankingService $openBankingService)
    {
        $this->openBankingService = $openBankingService;
    }

    /**
     * List available countries
     *
     * @return array $countries Available countries
     */
    public function listAvailableCountries()
    {
        $countries = $this->openBankingService->listAvailableCountries();
        return api_response($countries, __('responses.data_retrieved_successfully'), 200);
    }

    /**
     * List available banks by country
     *
     * @param  object  $request data from the form (country)
     * @return array $banks Available banks
     */
    public function listBanks(Request $request)
    {
        $country = $request->input('country');
        $banks = $this->openBankingService->listAvailableBanksByCountry($country);
        if (!$banks) {
            return api_response($banks, __('responses.item_not_found'), 404);
        }
        return api_response($banks, __('responses.data_retrieved_successfully'), 200);
    }

    /**
     * Initiate session
     *
     * @param  object  $request data from the form (redirect_url, institution_id)
     * @return array $session Session
     */
    public function initSession(Request $request)
    {
        $redirectUrl = $request->input('redirect_url') ?? url('/accounts');
        $institutionId = $request->input('institution_id');
        $session = $this->openBankingService->initSession($redirectUrl, $institutionId);
        if (!$session) {
            return api_response($session, __('responses.error_occurred'), 500);
        }
        return api_response($session, __('responses.data_retrieved_successfully'), 200);
    }

    /**
     * Create open banking account
     *
     * @param  object  $request data from the form (requisition_id)
     * @return array $account Account
     */
    public function createOpenBankingAccount(Request $request)
    {
        $requisitionId = $request->input('requisition_id');
        $account = $this->openBankingService->createOpenBankingAccount($requisitionId);
        if (!$account) {
            return api_response($account, __('responses.error_occurred'), 500);
        }
        return api_response($account, __('responses.data_retrieved_successfully'), 200);
    }
}
