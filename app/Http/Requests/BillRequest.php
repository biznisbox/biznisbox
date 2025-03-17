<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'number' => 'string|max:255',
            'supplier_id' => 'nullable|exists:partners,id',
            'supplier_name' => 'nullable|string',
            'supplier_address_id' => 'nullable|exists:partner_addresses,id',
            'supplier_address' => 'nullable|string',
            'supplier_city' => 'nullable|string',
            'supplier_zip_code' => 'nullable|string',
            'supplier_country' => 'nullable|string',
            'currency' => 'required|string',
            'currency_rate' => 'nullable|numeric',
            'payment_method' => 'nullable|string',
            'status' => 'nullable|string',
            'date' => 'required|date',
            'due_date' => 'required|date',
            'notes' => 'nullable|string',
            'footer' => 'nullable|string',
            'discount' => 'nullable|numeric',
            'discount_type' => 'nullable|string',
            'total' => 'required|numeric',
            'tax' => 'nullable|numeric',
        ];
    }
}
