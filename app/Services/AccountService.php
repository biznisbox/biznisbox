<?php

namespace App\Services;

use App\Models\Account;

class AccountService
{
    private $accountModel;

    public function __construct()
    {
        $this->accountModel = new Account();
    }

    public function getAccounts()
    {
        $accounts = $this->accountModel->orderBy('name', 'asc')->get();
        createActivityLog('retrieve', null, Account::$modelName, 'Account');
        return $accounts;
    }

    public function getAccount($id)
    {
        $account = $this->accountModel->with('transactions')->where('id', $id)->first();
        createActivityLog('retrieve', $id, Account::$modelName, 'Account');
        return $account;
    }

    public function createAccount($data)
    {
        if ($data['is_default']) {
            $this->accountModel->changeDefaultAccount();
        }
        $account = $this->accountModel->create($data);
        if ($account) {
            sendWebhookForEvent('account:created', $account->toArray());
            return true;
        }
        return false;
    }

    public function updateAccount($id, $data)
    {
        $account = $this->accountModel->where('id', $id)->first();
        if ($data['is_default']) {
            $this->accountModel->changeDefaultAccount();
        }
        $account->update($data);
        if ($account) {
            sendWebhookForEvent('account:updated', $account->toArray());
            return true;
        }
        return false;
    }

    public function deleteAccount($id)
    {
        $account = $this->accountModel->where('id', $id)->first();
        $accountData = $account->toArray();
        if ($account->is_default == 1) {
            return [
                'error' => true,
                'message' => __('responses.default_account_cannot_be_deleted'),
            ];
        }
        $account = $account->delete();
        if ($account) {
            sendWebhookForEvent('account:deleted', $accountData);
            return true;
        }
        return $account;
    }
}
