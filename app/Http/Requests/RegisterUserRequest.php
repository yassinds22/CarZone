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
            'name'      => '',
            'email'     => '',
            'password'  => '',
            'google_id' => '',
            'phone'     => '',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            // 'name'      => 'الاسم مطلوب',
            // 'email.required'     => 'البريد الإلكتروني مطلوب',
            // 'email.email'        => 'البريد الإلكتروني غير صحيح',
            // 'email.unique'       => 'البريد الإلكتروني مستخدم مسبقًا',
            // 'password.required'  => 'كلمة المرور مطلوبة',
            // 'password.min'       => 'كلمة المرور يجب أن تكون على الأقل 6 أحرف',
            // 'password.confirmed' => 'تأكيد كلمة المرور غير متطابق',
            // 'google_id.unique'   => 'هذا الحساب موجود مسبقًا',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // تنظيف البيانات قبل التحقق
        $this->merge([
            'email' => strtolower($this->email),
        ]);
    }
}