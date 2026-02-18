<?php

namespace App\Http\Requests;

use App\DTO\ChangePasswordDTO;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'email' => 'required',
            'password' => 'required',
            'confirmPassword' => 'required',
        ];
    }
    public function toDTO() : ChangePasswordDTO {
        return new ChangePasswordDTO(
            email: $this->validated('email'),
            password: $this->validated('password'),
            confirmPassword: $this->validated('confirmPassword')
        );
    }
}
