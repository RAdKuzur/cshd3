<?php

namespace App\Http\Requests;

use App\DTO\HistoryResourceDTO;
use Illuminate\Foundation\Http\FormRequest;

class HistoryResourceRequest extends FormRequest
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
            'resource_id' => 'required|integer',
            'amount' => 'required|integer'
        ];
    }

    public function toDTO() : HistoryResourceDTO {
        return new HistoryResourceDTO(
            resource_id: $this->validated('resource_id'),
            amount: $this->validated('amount')
        );
    }
}
