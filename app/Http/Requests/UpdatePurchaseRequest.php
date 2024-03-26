<?php

namespace App\Http\Requests;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdatePurchaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'product_id' => 'required|integer|exists:products,id',
            'date' => 'required|date',
            'quantity' => 'required|integer',
            'unit_price' => 'required|numeric',
        ];
    }

    /**
     * Get the translated validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'supplier_id.required' => 'حقل مُزوّد المنتج مطلوب.',
            'supplier_id.integer' => 'حقل مُزوّد المنتج يجب أن يكون عبارة عن رقم صحيح.',
            'supplier_id.exists' => 'المُزوّد المحدد غير موجود.',
            'product_id.required' => 'حقل المنتج مطلوب.',
            'product_id.integer' => 'حقل المنتج يجب أن يكون عبارة عن رقم صحيح.',
            'product_id.exists' => 'المنتج المحدد غير موجود.',
            'date.required' => 'حقل التاريخ مطلوب.',
            'date.date' => 'حقل التاريخ يجب أن يكون تاريخ صحيح.',
            'quantity.required' => 'حقل الكمية مطلوب.',
            'quantity.integer' => 'حقل الكمية يجب أن تكون عبارة عن رقم صحيح.',
            'unit_price.required' => 'حقل السعر الإجمالي مطلوب.',
            'unit_price.numeric' => 'حقل السعر الإجمالي يجب أن يكون رقمًا.',
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
