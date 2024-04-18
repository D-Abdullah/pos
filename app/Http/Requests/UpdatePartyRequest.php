<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdatePartyRequest extends FormRequest
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
            'client_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'date' => 'required|date',
            'status' => 'required|string|max:255',
        ];
    }
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
