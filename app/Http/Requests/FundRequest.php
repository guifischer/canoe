<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FundRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'aliases' => ['sometimes', 'array', 'nullable'],
            'aliases.*' => ['sometimes', 'string', 'nullable'],
            'start_year' => ['required', 'integer', 'min:1900', 'max:' . date('Y')],
            'manager_id' => ['required', 'integer', 'exists:fund_managers,id'],
        ];
    }
}
