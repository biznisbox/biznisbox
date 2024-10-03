<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ContractService;

class ContractController extends Controller
{
    private $contractService;

    public function __construct()
    {
        $this->contractService = new ContractService();
    }

    public function getContracts()
    {
        $contracts = $this->contractService->getContracts();
        return api_response($contracts, __('responses.data_retrieved_successfully'), 200);
    }

    public function getContract($id)
    {
        $contract = $this->contractService->getContract($id);
        return api_response($contract, __('responses.data_retrieved_successfully'), 200);
    }

    public function createContract(Request $request)
    {
        $data = $request->all();
        $contract = $this->contractService->createContract($data);
        return api_response($contract, __('responses.item_created_successfully'), 200);
    }

    public function updateContract(Request $request, $id)
    {
        $data = $request->all();
        $contract = $this->contractService->updateContract($id, $data);
        return api_response($contract, __('responses.item_updated_successfully'), 200);
    }

    public function deleteContract($id)
    {
        $contract = $this->contractService->deleteContract($id);
        return api_response($contract, __('responses.item_deleted_successfully'), 200);
    }

    public function getContractNumber()
    {
        $contract = $this->contractService->getContractNumber();
        return api_response($contract, __('responses.item_retrieved_successfully'), 200);
    }

    public function getContractPdf(Request $request, $id)
    {
        if (!$request->hasValidSignatureWhileIgnoring(['lang'])) {
            return api_response(null, __('responses.invalid_signature'), 400);
        }
        $type = $request->input('type', 'stream');
        $pdf = $this->contractService->getContractPdf($id, $type);
        return $pdf;
    }
}
