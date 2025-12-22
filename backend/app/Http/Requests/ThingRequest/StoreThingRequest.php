<?php

namespace App\Http\Requests\ThingRequest;


use Illuminate\Foundation\Http\FormRequest;

class StoreThingRequest extends FormRequest {

    public function authorize() : bool {
        return true;
    }

    public function rules(): array {
        return [
            'name' => 'required|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'inv_number' => 'nullable|string|max:255',
            'operation_date' => 'required|date',
            'thing_type_id' => 'required|integer',
            'condition' => 'required|integer',
            'balance' => 'required|numeric',
            'auditorium_id' => 'required|integer',
            'price' => 'nullable|numeric',
            'comment' => 'nullable|string',

            'is_composite' =>  'required|boolean',

            'children' => 'array',
            'children.*.name' => 'required_with:children|string|max:255',
            'children.*.serial_number' => 'nullable|string|max:255',
            'children.*.inv_number' => 'nullable|string|max:255',
            'children.*.thing_type_id' => 'required_with:children|integer',
            'children.*.price' => 'nullable|numeric',
            'children.*.condition' => 'nullable|integer'
        ];
    }
}
