<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreProductRequest extends FormRequest
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
            'name' => 'required|string',
            'department_id' => 'required|integer|exists:departments,id',
            'unit_price' => 'required|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            'name.required' => 'حقل الاسم مطلوب.',
            'name.string' => 'يجب أن يكون الاسم نصًا.',
            'department_id.required' => 'حقل القسم مطلوب.',
            'department_id.integer' => 'يجب أن يكون حقل القسم عددًا صحيحًا.',
            'department_id.exists' => 'القسم المحدد غير صحيح.',
            'description.required' => 'حقل الوصف مطلوب.',
            'description.string' => 'يجب أن يكون الوصف نصًا.',
            'unit_price.required' => 'سعر الوحده مطلوب',
            'unit_price.integer' => 'يجب أن يكون حقل سعر الوحده عددًا صحيحًا.',
            'image.image' => 'يجب أن يكون الملف ملف صورة.',
            'image.mimes' => 'يجب أن يكون الصورة من نوع jpeg, png, jpg, أو gif.',
            'image.max' => 'يجب ألا يتجاوز حجم الصورة 2 ميجابايت.',
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
