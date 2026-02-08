<?php

namespace App\Http\Requests;

use App\DTO\LicenceDTO;
use Illuminate\Foundation\Http\FormRequest;

class LicenceRequest extends FormRequest
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
            'licence_key' => 'required|string',
        ];
    }

    public function toDTO() : LicenceDTO {
        return new LicenceDTO(
            licenceKey: $this->validated('licence_key')
        );
    }
}
