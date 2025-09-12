<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ContractService;

/**
 * @group Contracts
 *
 * APIs for managing contracts
 * @authenticated
 */
class ContractController extends Controller
{
    private $contractService;

    public function __construct()
    {
        $this->contractService = new ContractService();
    }

    /**
     * Get all contracts
     *
     * @return array $contracts Contracts
     */
    public function getContracts()
    {
        $contracts = $this->contractService->getContracts();
        return apiResponse($contracts, __('responses.data_retrieved_successfully'), 200);
    }

    /**
     * Get contract by id
     *
     * @param  string  $id id of the contract
     * @return array $contract contract
     */
    public function getContract($id)
    {
        $contract = $this->contractService->getContract($id);
        return apiResponse($contract, __('responses.data_retrieved_successfully'), 200);
    }

    /**
     * Create a new contract
     *
     * @param  object  $request data from the form
     * @return array $contract contract
     */
    public function createContract(Request $request)
    {
        $data = $request->all();
        $contract = $this->contractService->createContract($data);
        return apiResponse($contract, __('responses.item_created_successfully'), 200);
    }

    /**
     * Update contract
     *
     * @param  object  $request data from the form
     * @param  string  $id id of the contract
     * @return array $contract contract
     */
    public function updateContract(Request $request, $id)
    {
        $data = $request->all();
        $contract = $this->contractService->updateContract($id, $data);
        return apiResponse($contract, __('responses.item_updated_successfully'), 200);
    }

    /**
     * Delete contract
     *
     * @param  string  $id id of the contract
     * @return array $contract contract
     */
    public function deleteContract($id)
    {
        $contract = $this->contractService->deleteContract($id);
        return apiResponse($contract, __('responses.item_deleted_successfully'), 200);
    }

    /**
     * Get contract number
     *
     * @return array $contract contract
     */
    public function getContractNumber()
    {
        $contract = $this->contractService->getContractNumber();
        return apiResponse($contract, __('responses.item_retrieved_successfully'), 200);
    }

    /**
     * Get contract pdf
     *
     * @param  object  $request data from the form
     * @param  string  $id id of the contract
     * @return array $contract contract
     */
    public function getContractPdf(Request $request, $id)
    {
        if (!$request->hasValidSignatureWhileIgnoring(['lang'])) {
            return apiResponse(null, __('responses.invalid_signature'), 400);
        }
        $type = $request->input('type', 'stream');
        return $this->contractService->getContractPdf($id, $type);
    }

    /**
     * Share contract
     *
     * @param  object  $request data from the form
     * @param  string  $id id of the contract
     * @return array $contract contract
     */
    public function shareContract(Request $request, $id)
    {
        $data = $request->all();
        $contract = $this->contractService->shareContract($id, $data);
        return apiResponse($contract, __('responses.item_shared_successfully'), 200);
    }
}
