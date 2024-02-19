<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email'=>'required|string|email',
            'password'=>'required|string'
        ];
    }
    /**
     * Get custom error messages for validator error.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'email.required' => 'حقل البريد الإلكتروني مطلوب.',
            'email.string' => 'يجب أن يكون حقل البريد الإلكتروني نصًا.',
            'email.email' => 'يجب أن يكون حقل البريد الإلكتروني عنوان بريد إلكتروني صحيح.',
            'password.required' => 'حقل كلمة المرور مطلوب.',
            'password.string' => 'يجب أن تكون حقل كلمة المرور نصًا.',
        ];
    }
}
