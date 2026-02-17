<?php

namespace App\Http\Requests\ThingRequest;


use Illuminate\Foundation\Http\FormRequest;

class UpdateThingRequest extends FormRequest {

    public function authorize() : bool {
        return true;
    }

    public function rules(): array
    {
        return [
            'condition' => ['nullable', 'integer'],
            'comment' => ['nullable', 'string'],

            'children' => ['nullable', 'array'],

            'children.create' => ['nullable', 'array'],
            'children.create.*.name' => ['required', 'string'],
            'children.create.*.thing_type_id' => ['required', 'integer'],
            'children.create.*.serial_number' => ['nullable', 'string'],
            'children.create.*.inv_number' => ['nullable', 'string'],
            'children.create.*.price' => ['nullable', 'numeric'],
            'children.create.*.condition' => ['nullable', 'integer'],

            'children.delete' => ['nullable', 'array'],
            'children.delete.*' => ['integer'],
        ];
    }
}
