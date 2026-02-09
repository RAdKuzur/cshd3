<?php

namespace App\DTO;

class ModelDTO implements DTO
{
    public ?int $id;
    public ?string $name;
    public ?int $company_id;
    public function __construct(
        ?int $id = null,
        ?string $name = null,
        ?int $company_id = null
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->company_id = $company_id;
    }

    public static function fromArray(array $array) : self {
        return new self(
            $array['id'],
            $array['name'],
            $array['company_id']
        );
    }

    public function toArray() : array {
        return [
            'name' => $this->name,
            'company_id' => $this->company_id
        ];
    }
}
