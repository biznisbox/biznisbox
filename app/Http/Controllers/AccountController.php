<?php

namespace App\Http\Controllers;

use App\Services\AccountService;
use App\Http\Requests\AccountRequest;

class AccountController extends Controller
{
    private $accountService;
    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function getAccounts()
    {
        $accounts = $this->accountService->getAccounts();
        if (!$accounts) {
            return api_response(null, __('responses.item_not_found'), 404);
        }
        return api_response($accounts, __('responses.data_retrieved_successfully'));
    }

    public function getAccount($id)
    {
        $account = $this->accountService->getAccount($id);
        if (!$account) {
            return api_response(null, __('responses.item_not_found_with_id'), 404);
        }
        return api_response($account, __('responses.data_retrieved_successfully'));
    }

    public function createAccount(AccountRequest $request)
    {
        $data = $request->all();
        $account = $this->accountService->createAccount($data);
        if (!$account) {
            return api_response(null, __('responses.item_not_created'), 400);
        }
        return api_response($account, __('responses.item_created_successfully'));
    }

    public function updateAccount(AccountRequest $request, $id)
    {
        $data = $request->all();
        $account = $this->accountService->updateAccount($id, $data);
        if (!$account) {
            return api_response(null, __('responses.item_not_updated'), 400);
        }
        return api_response($account, __('responses.item_updated_successfully'));
    }

    public function deleteAccount($id)
    {
        $account = $this->accountService->deleteAccount($id);
        if (!$account) {
            return api_response(null, __('responses.item_not_deleted'), 400);
        }
        return api_response($account, __('responses.item_deleted_successfully'));
    }
}
