<?php

namespace App\Services;

use App\Models\Transaction;

class TransactionService
{
    private $transactionModel;
    public function __construct()
    {
        $this->transactionModel = new Transaction();
    }

    public function getTransactions()
    {
        return $this->transactionModel->getTransactions();
    }

    public function getTransaction($id)
    {
        return $this->transactionModel->getTransaction($id);
    }

    public function createTransaction($data)
    {
        return $this->transactionModel->createTransaction($data);
    }

    public function updateTransaction($id, $data)
    {
        return $this->transactionModel->updateTransaction($id, $data);
    }

    public function deleteTransaction($id)
    {
        return $this->transactionModel->deleteTransaction($id);
    }

    public function getTransactionNumber()
    {
        return $this->transactionModel->getTransactionNumber();
    }

    public function getTransactionsByAccountId($account_id)
    {
        return $this->transactionModel->getTransactionsByAccountId($account_id);
    }
}
