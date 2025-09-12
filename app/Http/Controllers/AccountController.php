<?php

namespace App\Http\Controllers;

use App\Services\AccountService;
use App\Http\Requests\AccountRequest;

/**
 * @group Accounts
 *
 * APIs for managing accounts
 * @authenticated
 */
class AccountController extends Controller
{
    private $accountService;
    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    /**
     * Get all accounts
     * @apiResourceModel App\Models\User
     *
     * @return array $accounts All accounts
     */
    public function getAccounts()
    {
        $accounts = $this->accountService->getAccounts();
        if (!$accounts) {
            return apiResponse(null, __('responses.item_not_found'), 404);
        }
        return apiResponse($accounts, __('responses.data_retrieved_successfully'));
    }

    /**
     * Get account by id
     * @apiResourceModel App\Models\User
     * @urlParam id required The id of the account
     *
     * @param  string  $id id of the account
     * @return array $account account
     */
    public function getAccount($id)
    {
        $account = $this->accountService->getAccount($id);
        if (!$account) {
            return apiResponse(null, __('responses.item_not_found_with_id'), 404);
        }
        return apiResponse($account, __('responses.data_retrieved_successfully'));
    }

    /**
     * Create a new account
     * @apiResourceModel App\Models\User
     *
     * @param  object  $request data from the form (name)
     * @return array $account account
     */
    public function createAccount(AccountRequest $request)
    {
        $data = $request->all();
        $account = $this->accountService->createAccount($data);
        if (!$account) {
            return apiResponse(null, __('responses.item_not_created'), 400);
        }
        return apiResponse($account, __('responses.item_created_successfully'));
    }

    /**
     * Update an account
     * @apiResourceModel App\Models\User
     *
     * @param  object  $request data from the form (name)
     * @param  string  $id id of the account
     * @return array $account account
     */
    public function updateAccount(AccountRequest $request, $id)
    {
        $data = $request->all();
        $account = $this->accountService->updateAccount($id, $data);
        if (!$account) {
            return apiResponse(null, __('responses.item_not_updated'), 400);
        }
        return apiResponse($account, __('responses.item_updated_successfully'));
    }

    /**
     * Delete an account
     * @apiResourceModel App\Models\User
     * @urlParam id required The id of the account
     *
     * @param  string  $id id of the account
     * @return array $account account
     */
    public function deleteAccount($id)
    {
        $account = $this->accountService->deleteAccount($id);
        if (!$account) {
            return apiResponse(null, __('responses.item_not_deleted'), 400);
        }
        return apiResponse($account, __('responses.item_deleted_successfully'));
    }
}
