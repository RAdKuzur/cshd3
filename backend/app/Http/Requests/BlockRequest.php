<?php

namespace App\Http\Requests;

use App\DTO\BlockDTO;
use Illuminate\Foundation\Http\FormRequest;
use PhpParser\Node\Stmt\Block;

class BlockRequest extends FormRequest
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
            'url' => 'required|string',
        ];
    }
    public function toDTO(): BlockDTO {
        return new BlockDTO(
            url: $this->validated('url')
        );
    }
}
