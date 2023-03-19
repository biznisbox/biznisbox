<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    protected $transactionModel;

    public function __construct(Transaction $transactionModel)
    {
        $this->transactionModel = $transactionModel;
    }

    public function getTransactions()
    {
        $transactions = $this->transactionModel->getTransactions();

        if ($transactions) {
            return api_response($transactions, __('response.transactions.get_success'));
        }
        return api_response(null, __('response.transactions.get_failed'), 400);
    }

    public function getTransaction($id)
    {
        $transaction = $this->transactionModel->getTransaction($id);

        if ($transaction) {
            return api_response($transaction, __('response.transaction.get_success'));
        }
        return api_response(null, __('response.transaction.not_found'), 404);
    }

    public function createTransaction(Request $request)
    {
        $data = $request->all();
        $transaction = $this->transactionModel->createTransaction($data);

        if ($transaction) {
            return api_response($transaction, __('response.transaction.create_success'), 201);
        }
        return api_response(null, __('response.transaction.create_failed'), 400);
    }

    public function updateTransaction(Request $request, $id)
    {
        $data = $request->all();
        $transaction = $this->transactionModel->updateTransaction($id, $data);

        if ($transaction) {
            return api_response($transaction, __('response.transaction.update_success'));
        }
        return api_response(null, __('response.transaction.update_failed'), 400);
    }

    public function deleteTransaction($id)
    {
        $transaction = $this->transactionModel->deleteTransaction($id);

        if ($transaction) {
            return api_response(null, __('response.transaction.delete_success'));
        }
        return api_response(null, __('response.transaction.delete_failed'), 400);
    }

    public function getTransactionNumber()
    {
        $transaction = $this->transactionModel->getTransactionNumber();
        if ($transaction) {
            return api_response($transaction, __('response.transaction.get_success'));
        }
        return api_response(null, __('response.transaction.not_found'), 404);
    }
}
