<?php

namespace App\Http\Requests;

use App\DTO\Thing\ThingDTO;
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
            'auditorium_id' => 'nullable',
            'condition' => 'nullable',
            'thing_parent_id' => 'nullable',
            'price' => 'nullable',
            'comment' => 'nullable',
            'balance' => 'nullable'
        ];
    }
    public function toThingDTO() : ThingDTO {
        return new ThingDTO(
            name: $this->validated('name'),
            serial_number: $this->validated('serial_number'),
            inv_number: $this->validated('inv_number'),
            operation_date: $this->validated('operation_date'),
            thing_type_id: $this->validated('thing_type_id'),
            condition: $this->validated('condition'),
            balance: $this->validated('balance'),
            auditorium_id: $this->validated('auditorium_id'),
            price: $this->validated('price'),
            comment: $this->validated('comment'),
            is_composite: $this->validated('thing_parent_id'),
        );
    }
}
