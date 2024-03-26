<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateEolRequest extends FormRequest
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
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer',
            'reason' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'quantity.required' => 'حقل الكمية مطلوب.',
            'quantity.integer' => 'يجب أن تكون الكمية عددًا صحيحًا.',
            'product_id.required' => 'حقل المنتج مطلوب.',
            'product_id.integer' => 'يجب أن يكون حقل المنتج عددًا صحيحًا.',
            'product_id.exists' => 'المنتج المحدد غير صحيح.',
            'reason.required' => 'حقل السبب مطلوب.',
            'reason.string' => 'يجب أن يكون السبب نصًا.',
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
