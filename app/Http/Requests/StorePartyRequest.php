<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'client_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'date' => 'required|date',
            'status' => 'required|string|max:255',
            'deposits.*.cost' => 'required|numeric',
            'deposits.*.date' => 'required|date',
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
            'name.required' => 'حقل الاسم مطلوب.',
            'name.string' => 'يجب أن يكون الاسم نصاً.',
            'name.max' => 'الاسم يجب ألا يتجاوز 255 حرفاً.',
            'address.required' => 'حقل العنوان مطلوب.',
            'address.string' => 'يجب أن يكون العنوان نصاً.',
            'address.max' => 'العنوان يجب ألا يتجاوز 255 حرفاً.',
            'date.required' => 'حقل التاريخ مطلوب.',
            'date.date' => 'صيغة التاريخ غير صحيحة.',
            'status.required' => 'حقل الحالة مطلوب.',
            'status.string' => 'يجب أن تكون الحالة نصاً.',
            'status.max' => 'الحالة يجب ألا تتجاوز 255 حرفاً.',
            'deposits.*.cost.required' => 'حقل التكلفة مطلوب.',
            'deposits.*.cost.numeric' => 'يجب أن تكون التكلفة رقماً.',
            'deposits.*.date.required' => 'حقل التاريخ مطلوب.',
            'deposits.*.date.date' => 'صيغة التاريخ غير صحيحة.',
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
