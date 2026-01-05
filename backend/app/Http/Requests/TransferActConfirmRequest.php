<?php

namespace App\Http\Requests;

use App\DTO\TransferActConfirmDTO;
use Illuminate\Foundation\Http\FormRequest;

class TransferActConfirmRequest extends FormRequest
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
            'transfer_act_id' => 'integer|required',
            'username' => 'string|required',
        ];
    }
    public function toDTO() {
        return new TransferActConfirmDTO(
            transfer_act_id: $this->validated('transfer_act_id'),
            username: $this->validated('username'),
        );
    }
}
