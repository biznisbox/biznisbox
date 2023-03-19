<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accounts;

class AccountController extends Controller
{
    protected $accountModel;

    public function __construct()
    {
        $this->accountModel = new Accounts();
    }

    public function getAccounts()
    {
        $accounts = $this->accountModel->getAccounts();
        return api_response($accounts, __('response.accounts.get_success'), 200);
    }

    public function getAccount($id)
    {
        $account = $this->accountModel->getAccount($id);
        return api_response($account, __('response.accounts.get_success'), 200);
    }

    public function createAccount(Request $request)
    {
        $data = $request->all();
        $account = $this->accountModel->createAccount($data);

        if ($account) {
            return api_response(null, __('response.accounts.create_success'), 200);
        }
        return api_response(null, __('response.accounts.create_error'), 500);
    }

    public function updateAccount(Request $request, $id)
    {
        $data = $request->all();
        $account = $this->accountModel->updateAccount($id, $data);

        if ($account) {
            return api_response(null, __('response.accounts.update_success'), 200);
        }
        return api_response(null, __('response.accounts.update.update_error'), 500);
    }

    public function deleteAccount($id)
    {
        $account = $this->accountModel->deleteAccount($id);

        if ($account) {
            return api_response(null, __('response.accounts.delete_success'), 200);
        }
        return api_response(null, __('response.accounts.delete_error'), 500);
    }
}
