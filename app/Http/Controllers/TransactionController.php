<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TransactionRequest;
use App\Services\TransactionService;

class TransactionController extends Controller
{
    private $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function getTransactions()
    {
        $transactions = $this->transactionService->getTransactions();
        if (!$transactions) {
            return api_response($transactions, __('responses.item_not_found'), 400);
        }
        return api_response($transactions, __('responses.data_retrieved_successfully'));
    }

    public function getTransaction($id)
    {
        $transaction = $this->transactionService->getTransaction($id);
        if (!$transaction) {
            return api_response($transaction, __('responses.item_not_found_with_id'), 404);
        }
        return api_response($transaction, __('responses.data_retrieved_successfully'));
    }

    public function createTransaction(TransactionRequest $request)
    {
        $data = $request->all();
        $transaction = $this->transactionService->createTransaction($data);
        if (!$transaction) {
            return api_response($transaction, __('responses.item_not_created'), 400);
        }
        return api_response($transaction, __('responses.item_created_successfully'));
    }

    public function updateTransaction(TransactionRequest $request, $id)
    {
        $data = $request->all();
        $transaction = $this->transactionService->updateTransaction($id, $data);
        if (!$transaction) {
            return api_response($transaction, __('responses.item_not_updated'), 400);
        }
        return api_response($transaction, __('responses.item_updated_successfully'));
    }

    public function deleteTransaction($id)
    {
        $transaction = $this->transactionService->deleteTransaction($id);
        if (!$transaction) {
            return api_response($transaction, __('responses.item_not_deleted'), 400);
        }
        return api_response($transaction, __('responses.item_deleted_successfully'));
    }

    public function getTransactionNumber()
    {
        $number = $this->transactionService->getTransactionNumber();
        if (!$number) {
            return api_response($number, __('responses.item_not_found'), 400);
        }
        return api_response($number, __('responses.data_retrieved_successfully'));
    }
}
