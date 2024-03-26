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
            // 'deposits' => 'array|filled',
            // 'deposits.*.cost' => ['required', 'numeric'],
            // 'deposits.*.date' => ['required', 'date'],
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
