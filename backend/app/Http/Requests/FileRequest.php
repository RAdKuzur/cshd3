<?php

namespace App\Http\Requests;

use App\DTO\FileDTO;
use Illuminate\Foundation\Http\FormRequest;

class FileRequest extends FormRequest
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
            'table_name' => 'required|string',
            'row_id' => 'required|integer',
            'file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'files' => 'nullable|array',
            'files.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ];
    }
    public function toFileDTO(): FileDTO
    {
        return new FileDTO(
            table_name: $this->validated('table_name'),
            row_id: $this->validated('row_id'),
            file: $this->hasFile('file') ? $this->file('file') : null,
        );
    }
}
