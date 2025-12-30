<?php

namespace App\Http\Requests;

use App\DTO\TransferActDTO;
use Illuminate\Foundation\Http\FormRequest;

class TransferActRequest extends FormRequest
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
            'from' => 'nullable',
            'to' => 'nullable',
            'type' => 'integer|required',
            'date' => 'required',
            'things' => 'nullable|array',
            'deletedThings' => 'nullable|array'
        ];
    }

    public function toTransferActDTO() : TransferActDTO {
        return new TransferActDTO(
            from: $this->validated('from'),
            to: $this->validated('to'),
            date: $this->validated('date'),
            type: $this->validated('type'),
            things: $this->validated('things'),
            deletedThings: $this->validated('deletedThings')
        );
    }
}
