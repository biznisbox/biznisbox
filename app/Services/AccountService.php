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
        $accounts = $this->accountModel->getAccounts();
        return $accounts;
    }

    public function getAccount($id)
    {
        $account = $this->accountModel->getAccount($id);
        return $account;
    }

    public function createAccount($data)
    {
        $account = $this->accountModel->createAccount($data);
        return $account;
    }

    public function updateAccount($id, $data)
    {
        $account = $this->accountModel->updateAccount($id, $data);
        return $account;
    }

    public function deleteAccount($id)
    {
        $account = $this->accountModel->deleteAccount($id);
        return $account;
    }
}
