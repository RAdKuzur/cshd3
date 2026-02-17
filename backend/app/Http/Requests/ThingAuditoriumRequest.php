<?php

namespace App\Http\Requests;

use App\DTO\ThingAuditoriumDTO;
use Illuminate\Foundation\Http\FormRequest;

class ThingAuditoriumRequest extends FormRequest
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
            'auditorium_id' => 'required|integer',
            'start_date' => 'required',
        ];
    }

    public function toDTO() {
        return new ThingAuditoriumDTO(
            thing_id: $this->validated('thing_id'),
            auditorium_id: $this->validated('auditorium_id'),
            start_date: $this->validated('start_date'),
            end_date: null
        );
    }
}
