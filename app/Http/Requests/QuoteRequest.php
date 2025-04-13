<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuoteRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_id' => 'nullable|exists:partners,id',
            'payer_id' => 'nullable|exists:partners,id',
            'customer_address_id' => 'nullable|exists:partner_addresses,id',
            'payer_address_id' => 'nullable|exists:partner_addresses,id',
            'sales_person_id' => 'nullable|exists:employees,id',
            'payment_method_id' => 'nullable|string',
            'date' => 'required|date',
            'valid_until' => 'required|date',
            'number' => 'string|max:255',
            'type' => 'nullable|string',
            'status' => 'nullable|string',
            'currency' => 'required|string',
            'currency_rate' => 'nullable|numeric',
            'default_currency' => 'nullable|string',
            'customer_name' => 'nullable|string',
            'customer_address' => 'nullable|string',
            'customer_city' => 'nullable|string',
            'customer_zip_code' => 'nullable|string',
            'customer_country' => 'nullable|string',
            'payer_name' => 'nullable|string',
            'payer_address' => 'nullable|string',
            'payer_city' => 'nullable|string',
            'payer_zip_code' => 'nullable|string',
            'payer_country' => 'nullable|string',
            'notes' => 'nullable|string',
            'footer' => 'nullable|string',
            'discount_type' => 'nullable|string',
            'discount' => 'nullable|numeric',
            'tax' => 'nullable|numeric',
            'total' => 'nullable|numeric',
        ];
    }
}
