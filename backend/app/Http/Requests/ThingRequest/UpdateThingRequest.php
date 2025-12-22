<?php

namespace App\Http\Requests\ThingRequest;


use Illuminate\Foundation\Http\FormRequest;

class UpdateThingRequest extends FormRequest {

    public function authorize() : bool {
        return true;
    }

    public function rules(): array {
        return [

            'condition' => 'required|integer',
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
