<?php

namespace App\Http\Requests;

use App\DTO\NetworkThingDTO;
use Illuminate\Foundation\Http\FormRequest;

class NetworkThingRequest extends FormRequest
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
            'thing_id' => 'required|integer',
            'ip_address' => 'required|string',
            'phone_number' => 'required|string',
            'comment' => 'nullable|string',
        ];
    }

    public function toDTO(): NetworkThingDTO {
        return new NetworkThingDTO(
            thing_id: $this->validated('thing_id'),
            ip_address: $this->validated('ip_address'),
            phone_number: $this->validated('phone_number'),
            comment: $this->validated('comment'),
        );
    }
}
