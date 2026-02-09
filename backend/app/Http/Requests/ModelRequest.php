<?php

namespace App\Http\Requests;

use App\DTO\ModelDTO;
use Illuminate\Foundation\Http\FormRequest;

class ModelRequest extends FormRequest
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
            'name' => 'required|string',
            'company_id' => 'required|integer',
        ];
    }

    public function toDTO() : ModelDTO {
        return new ModelDTO(
            name: $this->validated('name'),
            company_id: $this->validated('company_id')
        );
    }
}
