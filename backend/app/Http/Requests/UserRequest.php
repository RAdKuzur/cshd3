<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'firstname' => 'string|required',
            'surname' => 'string|required',
            'patronymic' => 'string|nullable',
            'username' => 'string|required',
            'email' => 'string|required',
            'phone_number' => 'string|nullable',
            'birthdate' => 'nullable',
            'auditorium_id' => 'nullable',
            'bio' => 'nullable',
            'password' => 'string|nullable',
            'role' => 'required'
        ];
    }
}
