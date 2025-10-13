<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @bodyParam name string required The brand name. Example: Samsung
 * @bodyParam is_active boolean Whether the brand is active (optional). Example: true
 */
class StoreBrandRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Allow all users (you can restrict this later based on permissions)
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:brands,name',
            'is_active' => 'nullable|boolean',
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The brand name is required.',
            'name.string' => 'The brand name must be a string.',
            'name.max' => 'The brand name must not exceed 255 characters.',
            'name.unique' => 'The brand name already exists.',
            'is_active.boolean' => 'The is_active field must be either true or false.',
        ];
    }
}
