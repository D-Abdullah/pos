<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StorePurchaseRequest extends FormRequest
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
            'name.required' => 'حقل الاسم مطلوب.',
            'name.string' => 'حقل الاسم يجب أن يكون عبارة عن نص.',
            'email.required' => 'حقل البريد الإلكتروني مطلوب.',
            'email.string' => 'حقل البريد الإلكتروني يجب أن يكون عبارة عن نص.',
            'phone.required' => 'حقل رقم الهاتف مطلوب.',
            'phone.string' => 'حقل رقم الهاتف يجب أن يكون عبارة عن نص.',
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
            'total_price.required' => 'حقل السعر الإجمالي مطلوب.',
            'total_price.numeric' => 'حقل السعر الإجمالي يجب أن يكون رقمًا.',
            'deposits.array' => 'حقل الدفعات يجب أن يكون عبارة عن مصفوفة.',
            'deposits.*.date.required' => 'حقل التاريخ في الدفعات مطلوب.',
            'deposits.*.date.date' => 'حقل التاريخ في الدفعات يجب أن يكون تاريخ صحيح.',
            'deposits.*.cost.required' => 'حقل التكلفة في الدفعات مطلوب.',
            'deposits.*.cost.numeric' => 'حقل التكلفة في الدفعات يجب أن يكون رقمًا صحيحًا.',
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
