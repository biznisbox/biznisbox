<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'currency' => 'required|string|max:255',
            'description' => 'nullable|string',
            'opening_balance' => 'required|numeric',
            'date_opened' => 'required|date',
            'date_closed' => 'nullable|date',
            'bank_name' => 'nullable|string|max:255',
            'bank_address' => 'nullable|string|max:255',
            'bank_contact' => 'nullable|string|max:255',
            'iban' => 'nullable|string|max:255',
            'bic' => 'nullable|string|max:255',
            'is_default' => 'required|boolean',
            'is_active' => 'required|boolean',
            'open_banking_id' => 'nullable',
            'integration' => 'nullable|string|max:255',
        ];
    }
}
