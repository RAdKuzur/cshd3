<?php

namespace App\Http\Requests;

use App\DTO\TestDTO;
use Illuminate\Foundation\Http\FormRequest;

class TestsRequest extends FormRequest
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
            'tests' => 'required|array',
            'tests.*.username' => 'string|required',
            'tests.*.email' => 'string|required',
            'tests.*.number' => 'integer|required',
        ];


        /*
         Также могут быть динамические DTO
        if ($this->has('users')) {
            return [
                'tests' => 'required|array',
                'tests.*.username' => 'string|required',
                'tests.*.email' => 'string|required',
                'tests.*.number' => 'integer|required',
            ];
        }

        return [
            'email' => 'string|required',
            'username' => 'string|required',
            'number' => 'integer|required',
        ];
         */
    }

    public function toDTOs() : array {
        $dtos = [];
        foreach ($this->validated('tests') as $test) {
            $dtos[] = new TestDTO(
                email: $test['email'],
                username: $test['username'],
                number: $test['number']
            );
        }
        return $dtos;
    }
    /* Функция для динмаических DTO */
//    public function toDTOs(): array
//    {
//        if (!$this->has('tests')) {
//            return [$this->toDTO()]; // Один пользователь как массив из одного элемента
//        }
//        return array_map(
//            fn($test) => new TestDTO(
//                email: $test['email'],
//                username: $test['username'],
//                number: $test['number']
//            ),
//            $this->validated('users')
//        );
//    }
}
