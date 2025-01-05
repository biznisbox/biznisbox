<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Client\ContractService;

/**
 * @group Client Contracts
 *
 * APIs for managing contracts
 */
class ContractController extends Controller
{
    private $contractService;

    public function __construct(ContractService $contractService)
    {
        $this->contractService = $contractService;
    }

    /**
     * Get contract by key
     * 
     * @return array $contracts Contract
     */
    public function getContract(Request $request)
    {
        $key = $request->key;
        $contract = $this->contractService->getContract($key);

        if (!$contract) {
            return api_response(null, __('responses.item_not_found'), 404);
        }
        return api_response($contract, __('responses.data_retrieved_successfully'), 200);
    }

    /**
     * Sign contract
     * 
     * @param  object  $request data from the form (key, name, email, phone, address)
     * @return array $contract Contract
     */
    public function signContract(Request $request)
    {
        $key = $request->key;
        $data = $request->all();
        $contract = $this->contractService->signContract($key, $data);

        if (!$contract) {
            return api_response(null, __('responses.item_not_found'), 404);
        }
        return api_response($contract, __('responses.data_retrieved_successfully'), 200);
    }
}
