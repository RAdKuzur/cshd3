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
            'inv_number' => 'required',
            'serial_number' => 'required',
            'operation_date' => 'required',
            'thing_type_id' => 'required',
            'condition' => 'required',
            'thing_parent_id' => 'nullable',
            'price' => 'required',
            'comment' => 'nullable',
            'auditorium_id' => 'required',
        ];
    }
}
