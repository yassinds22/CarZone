<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'string|min:6',
            'google_id' => 'string',
            'phone'     => 'nullable|string',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            // يمكنك تفعيل الرسائل إذا أردت
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'email' => strtolower($this->email),
        ]);
    }

    /**
     * Define body parameters for Scribe API documentation.
     */
    public static function bodyParameters(): array
    {
        return [
            'name' => [
                'description' => 'The full name of the user',
                'example' => 'Yassin Ali'
            ],
            'email' => [
                'description' => 'User email address',
                'example' => 'yassin@example.com'
            ],
            'password' => [
                'description' => 'Password for login',
                'example' => 'secret123'
            ],
            'google_id' => [
                'description' => 'Optional Google account ID',
                'example' => '1234567890'
            ],
            'phone' => [
                'description' => 'Optional phone number',
                'example' => '+967770000000'
            ],
        ];
    }
}
