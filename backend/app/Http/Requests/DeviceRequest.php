<?php

namespace App\Http\Requests;

use App\DTO\DeviceDTO;
use Illuminate\Foundation\Http\FormRequest;

class DeviceRequest extends FormRequest
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
            'thing_id' => 'required|integer',
        ];
    }

    public function toDTO() : DeviceDTO {
        return new DeviceDTO(
            model_id: $this->validated('model_id'),
            thing_id: $this->validated('thing_id'),
        );
    }
}
