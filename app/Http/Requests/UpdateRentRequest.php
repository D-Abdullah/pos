<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateRentRequest extends FormRequest
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
            'quantity' => 'required|integer',
            'sale_price' => 'required|numeric',
            'rent_price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'supplier_id' => 'required|exists:suppliers,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'حقل الاسم مطلوب.',
            'name.string' => 'يجب أن يكون الاسم نصًا.',
            'quantity.required' => 'حقل الكمية مطلوب.',
            'quantity.integer' => 'يجب أن تكون الكمية عددًا صحيحًا.',
            'sale_price.required' => 'يجب ان يكون حقل سعر البيع مطلوب',
            'sale_price.integer' => 'يجب ان يكون سعر البيع صحيحا',
            'rent_price.required' => 'يجب ان يكون حقل سعر الايجار مطلوب',
            'rent_price.integer' => 'يجب ان يكون سعر الايجار صحيحا',
            'image.image' => 'يجب أن يكون الملف ملف صورة.',
            'image.mimes' => 'يجب أن يكون الصورة من نوع jpeg, png, jpg, أو gif.',
            'image.max' => 'يجب ألا يتجاوز حجم الصورة 2 ميجابايت.',
            'supplier_id.required' => 'المورد مطلوب',
            'supplier_id.exists' => 'المورد غير موجود',
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
