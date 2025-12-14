<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'inv_number' => 'nullable',
            'serial_number' => 'nullable',
            'operation_date' => 'nullable',
            'thing_type_id' => 'required',
            'condition' => 'nullable',
            'thing_parent_id' => 'nullable',
            'price' => 'nullable',
            'comment' => 'nullable',
            'balance' => 'nullable'
        ];
    }
}
