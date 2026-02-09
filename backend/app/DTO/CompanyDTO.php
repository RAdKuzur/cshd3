<?php

namespace App\DTO;

class CompanyDTO implements DTO
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
            $array['name'],
        );
    }

    public function toArray() : array {
        return [
            'name' => $this->name,
        ];
    }
}
