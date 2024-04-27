<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StorePartyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'client_id' => 'required|integer|exists:clients,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'date' => 'required|date',
            // 'status' => 'required|string|in:contracted,transported,completed',
            'd_cost' => 'required|numeric',
            'd_date' => 'required|date',
            'd_from' => ['required', 'string', Rule::in(['custody', 'safe'])],
            'd_employee_id' => ['nullable', 'required_if:d_from,custody', 'numeric', 'exists:employees,id'],
            'd_safe_id' => ['nullable', 'required_if:d_from,safe', 'numeric', 'exists:safes,id'],
            'd_is_paid' => ['required', 'boolean', Rule::in([0, 1])],
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
            'client_id.required' => 'حقل معرف العميل مطلوب.',
            'client_id.integer' => 'يجب أن يكون معرف العميل عدداً صحيحاً.',
            'client_id.exists' => 'العميل غير موجود في قاعدة البيانات.',
            'name.required' => 'حقل الاسم مطلوب.',
            'name.string' => 'يجب أن يكون الاسم نصاً.',
            'name.max' => 'الاسم يجب ألا يتجاوز 255 حرفاً.',
            'address.required' => 'حقل العنوان مطلوب.',
            'address.string' => 'يجب أن يكون العنوان نصاً.',
            'address.max' => 'العنوان يجب ألا يتجاوز 255 حرفاً.',
            'date.required' => 'حقل التاريخ مطلوب.',
            'date.date' => 'صيغة التاريخ غير صحيحة.',
            'd_cost.required' => 'حقل التكلفة مطلوب.',
            'd_cost.numeric' => 'يجب أن تكون التكلفة رقماً.',
            'd_date.required' => 'حقل التاريخ مطلوب.',
            'd_date.date' => 'صيغة التاريخ غير صحيحة.',
            'd_from.required' => 'الحقل من مطلوب.',
            'd_from.string' => 'الحقل من يجب أن يكون نصاً.',
            'd_from.in' => 'الحقل من يجب أن يكون من العده او من الخزنه.',
            'd_employee_id.required_if' => 'الموظف مطلوب.',
            'd_employee_id.numeric' => 'حقل الموظف يجب أن يكون رقماً.',
            'd_employee_id.exists' => 'حقل الموظف غير موجود في قاعدة البيانات.',
            'd_safe_id.required_if' => 'الخزنه مطلوبة.',
            'd_safe_id.numeric' => 'حقل الخزنه يجب أن يكون رقماً.',
            'd_safe_id.exists' => 'حقل الخزنه غير موجود في قاعدة البيانات.',
            'd_is_paid.required' => 'الدفعه الاولى حقل الدفع مطلوب.',
            'd_is_paid.boolean' => 'الدفعه الاولى حقل الدفع يجب أن يكون صحيحاً.',
            'd_is_paid.in' => 'الدفعه الأولى حقل الدفع يجب أن يكون منطقيا.',
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
