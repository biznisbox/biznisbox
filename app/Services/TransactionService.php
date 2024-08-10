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
        $transactions = $this->transactionModel->getTransactions();
        return $transactions;
    }

    public function getTransaction($id)
    {
        $transaction = $this->transactionModel->getTransaction($id);
        return $transaction;
    }

    public function createTransaction($data)
    {
        $transaction = $this->transactionModel->createTransaction($data);
        return $transaction;
    }

    public function updateTransaction($id, $data)
    {
        $transaction = $this->transactionModel->updateTransaction($id, $data);
        return $transaction;
    }

    public function deleteTransaction($id)
    {
        $transaction = $this->transactionModel->deleteTransaction($id);
        return $transaction;
    }

    public function getTransactionNumber()
    {
        $transaction = $this->transactionModel->getTransactionNumber();
        return $transaction;
    }

    public function getTransactionsByAccountId($account_id)
    {
        $transactions = $this->transactionModel->getTransactionsByAccountId($account_id);
        return $transactions;
    }
}
