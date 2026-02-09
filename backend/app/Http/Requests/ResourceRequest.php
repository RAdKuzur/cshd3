<?php

namespace App\Http\Requests;

use App\DTO\ResourceDTO;
use Illuminate\Foundation\Http\FormRequest;

class ResourceRequest extends FormRequest
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
            'type' => 'required|integer',
            'amount' => 'required|integer',
        ];
    }

    public function toDTO() : ResourceDTO {
        return new ResourceDTO(
            name: $this->validated('name'),
            type: $this->validated('type'),
            amount: $this->validated('amount'),
        );
    }
}
