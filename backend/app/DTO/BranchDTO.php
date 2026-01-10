<?php

namespace App\DTO;

class BranchDTO implements DTO
{

    public ?int $id;
    public ?string $name;
    public ?int $organization_id;

    public function __construct(
        ?int $id = null,
        ?string $name = null,
        ?int $organization_id = null
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->organization_id = $organization_id;
    }

    public static function fromArray(array $array) : self {
        return new self(
            $array['id'],
            $array['name'],
            $array['organization_id']
        );
    }

    public function toArray() : array {
        return [
            'name' => $this->name,
            'organization_id' => $this->organization_id
        ];
    }
}
