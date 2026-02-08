<?php

namespace App\Http\Requests;

use App\DTO\TechWorkDTO;
use App\Models\TechWork;
use Illuminate\Foundation\Http\FormRequest;

class TechWorkRequest extends FormRequest
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
            'end_time' => 'required',
        ];
    }
    public function toDTO() : TechWorkDTO {
        return new TechWorkDTO(
            startTime: now(),
            endTime: $this->validated('end_time'),
            status: TechWork::ACTIVE
        );
    }
}
