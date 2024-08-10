<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'invoice_id' => 'nullable|exists:invoices,id',
            'bill_id' => 'nullable|exists:bills,id',
            'customer_id' => 'nullable|exists:partners,id',
            'supplier_id' => 'nullable|exists:partners,id',
            'account_id' => 'nullable|exists:accounts,id',
            'category_id' => 'nullable|exists:categories,id',
            'payment_id' => 'nullable|exists:payments,id',
            'bank_transaction_id' => 'nullable|exists:bank_transactions,id',
            'number' => 'nullable|string',
            'type' => 'required|string',
            'from_account' => 'nullable|exists:accounts,id',
            'to_account' => 'nullable|exists:accounts,id',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'amount' => 'required|numeric',
            'currency' => 'required|string',
            'exchange_rate' => 'nullable|numeric',
            'payment_method' => 'nullable|string',
            'reference' => 'nullable|string',
            'status' => 'nullable',
            'date' => 'required|date',
            'reconciled' => 'nullable|boolean',
            'reconciled_at' => 'nullable|date',
        ];
    }
}
