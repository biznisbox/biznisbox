<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'nullable|exists:categories,id',
            'number' => 'string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sell_price' => 'required|numeric',
            'buy_price' => 'required|numeric',
            'stock' => 'nullable|numeric',
            'stock_min' => 'nullable|numeric',
            'stock_max' => 'nullable|numeric',
            'unit' => 'required|string|max:255',
            'active' => 'required|boolean',
            'type' => 'required|string|max:255',
            'barcode' => 'nullable|string|max:255',
            'tax' => 'nullable|numeric',
        ];
    }
}
