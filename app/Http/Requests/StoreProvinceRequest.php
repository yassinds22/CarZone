<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @group Provinces Management
 *
 * This request is used to validate data when creating a new province.
 *
 * @bodyParam name string required The name of the province. Example: Sana'a
 * @bodyParam parent_id integer nullable The ID of the parent province (if any). Example: 1
 */
class StoreProvinceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Allow all users temporarily – you can restrict based on permissions later
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
            'name' => 'required|string|max:255|unique:provinces,name',
            'parent_id' => 'nullable',
        ];
    }

    /**
     * Custom error messages (optional).
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The province name is required.',
            'name.unique' => 'This province name has already been used.',
            'parent_id.exists' => 'The selected parent province does not exist.',
        ];
    }
}
