<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'project_key' => 'nullable|string|max:15|unique:projects,project_key',
            'number' => 'nullable|string|max:255',
            'partner_id' => 'nullable|exists:partners,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|string|max:255',
            'priority' => 'nullable|string|max:255',
            'budget' => 'nullable|numeric',
            'is_billable' => 'nullable|boolean',
            'active' => 'nullable|boolean',
        ];
    }
}
