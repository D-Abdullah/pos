<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class FTRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['required', 'string', Rule::in(['income', 'expense'])],
            'description' => ['required', 'string'],
            'amount' => ['required', 'numeric'],
            'party_id' => ['nullable', 'numeric', 'exists:parties,id'],
            'financial_transaction_type_id' => ['required', 'numeric', 'exists:financial_transaction_types,id'],
            'from' => ['required', 'string', Rule::in(['custody', 'safe'])],
            'employee_id' => ['nullable', 'required_if:from,custody', 'numeric', 'exists:employees,id'],
            'safe_id' => ['nullable', 'required_if:from,safe', 'numeric', 'exists:safes,id'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'type.required' => 'حقل النوع مطلوب.',
            'type.string' => 'يجب أن يكون النوع نصًا.',
            'type.in' => 'النوع يجب أن يكون إما "دخل" أو "مصروف".',
            'description.required' => 'حقل الوصف مطلوب.',
            'description.string' => 'يجب أن يكون الوصف نصًا.',
            'amount.required' => 'حقل المبلغ مطلوب.',
            'amount.numeric' => 'يجب أن يكون المبلغ رقمًا.',
            'party_id.numeric' => 'يجب أن يكون رقم الطرف رقمًا.',
            'party_id.exists' => 'الطرف المحدد غير موجود.',
            'financial_transaction_type_id.required' => 'حقل نوع العملية المالية مطلوب.',
            'financial_transaction_type_id.numeric' => 'يجب أن يكون رقم نوع العملية المالية رقمًا.',
            'financial_transaction_type_id.exists' => 'نوع العملية المالية المحدد غير موجود.',
            'from.required' => 'حقل المصدر مطلوب.',
            'from.string' => 'يجب أن يكون المصدر نصًا.',
            'employee_id.required_if' => 'حقل معرف الموظف مطلوب عندما يكون المصدر هو الحراسة.',
            'employee_id.numeric' => 'يجب أن يكون معرف الموظف رقمًا.',
            'employee_id.exists' => 'معرف الموظف المحدد غير موجود.',
            'safe_id.required_if' => 'حقل معرف الخزينة مطلوب عندما يكون المصدر هو الخزينة.',
            'safe_id.numeric' => 'يجب أن يكون معرف الخزينة رقمًا.',
            'safe_id.exists' => 'معرف الخزينة المحدد غير موجود.',
        ];

    }

    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     */
    protected function failedValidation(Validator $validator): void
    {
        $firstError = $validator->errors()->first();

        throw new HttpResponseException(
            redirect()->back()->with(['error' => $firstError])->withInput($this->all())
        );
    }
}
