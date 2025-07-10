<?php

namespace App\Http\Controllers\ClientPortal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\ClientPortal\ContractService;

class ContractController extends Controller
{
    private $contractService;

    public function __construct(ContractService $contractService)
    {
        $this->contractService = $contractService;
    }

    public function getContracts()
    {
        $contracts = $this->contractService->getContracts();
        if (!$contracts) {
            return api_response(null, __('responses.item_not_found'), 404);
        }
        return api_response($contracts, __('responses.data_retrieved_successfully'));
    }

    public function getContract($id)
    {
        $contract = $this->contractService->getContract($id);
        if (!$contract) {
            return api_response(null, __('responses.item_not_found'), 404);
        }
        return api_response($contract, __('responses.data_retrieved_successfully'));
    }
}
