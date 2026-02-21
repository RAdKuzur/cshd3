<?php

namespace App\Http\Requests;

use App\DTO\PeoplePositionDTO;
use Illuminate\Foundation\Http\FormRequest;

class PeoplePositionRequest extends FormRequest
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
            'people_id' => 'required|integer',
            'position_id' => 'required|integer',
            'branch_id' => 'required|integer',
            'start_date' => 'required',
        ];
    }

    public function toDTO() : PeoplePositionDTO {
        return new PeoplePositionDTO(
            people_id: $this->validated('people_id'),
            position_id: $this->validated('position_id'),
            branch_id: $this->validated('branch_id'),
            start_date: $this->validated('start_date')
        );
    }
}
