<?php

namespace App\Http\Requests;

use App\DTO\AuditoriumDTO;
use Illuminate\Foundation\Http\FormRequest;

class AuditoriumRequest extends FormRequest
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
            'name' => 'required',
            'number' => 'required',
            'floor' => 'required',
            'department_id' => 'required',
            'branch_id' => 'required'
        ];
    }
    public function toDTO(){
        return new AuditoriumDTO(
            name: $this->validated('name'),
            number: $this->validated('number'),
            floor: $this->validated('floor'),
            department_id: $this->validated('department_id'),
            branch_id: $this->validated('branch_id')
        );
    }
}
