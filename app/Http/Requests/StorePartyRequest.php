<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePartyRequest extends FormRequest
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
            'client_id'=>'required|integer|exists:clients,id',
            'name'=>'required|string',
            'address'=>'required|string',
            'date'=>'required|date',
            'status'=>'required|string|in:contracted,Transported, completed',
            'added_by'=>'required|integer|exists:users,id'
        ];
    }
}
