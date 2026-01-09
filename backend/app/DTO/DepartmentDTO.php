<?php

namespace App\DTO;

class DepartmentDTO implements DTO
{
    public ?int $id;
    public ?string $name;

    public function __construct(
        ?int $id = null,
        ?string $name = null,
    )
    {
        $this->id = $id;
        $this->name = $name;
    }

    public static function fromArray(array $array) : self {
        return new self(
            $array['id'],
            $array['name']
        );
    }

    public function toArray() : array {
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }
}
