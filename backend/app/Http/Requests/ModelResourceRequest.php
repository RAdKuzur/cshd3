<?php

namespace App\Http\Requests;

use App\DTO\ModelResourceDTO;
use Illuminate\Foundation\Http\FormRequest;

class ModelResourceRequest extends FormRequest
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
            'model_id' => 'required|integer',
            'resource_id' => 'required|integer',
        ];
    }

    public function toDTO() : ModelResourceDTO {
        return new ModelResourceDTO(
            model_id: $this->validated('model_id'),
            resource_id: $this->validated('resource_id'),
        );
    }
}
