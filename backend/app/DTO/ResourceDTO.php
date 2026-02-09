<?php

namespace App\DTO;

class ResourceDTO implements DTO
{
    public ?int $id;
    public ?string $name;
    public ?int $type;
    public ?int $amount;
    public function __construct(
        ?int $id = null,
        ?string $name = null,
        ?int $type = null,
        ?int $amount = null
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->amount = $amount;
    }

    public static function fromArray(array $array) : self {
        return new self(
            $array['id'],
            $array['name'],
            $array['type'],
            $array['amount']
        );
    }

    public function toArray() : array {
        return [
            'name' => $this->name,
            'type' => $this->type,
            'amount' => $this->amount
        ];
    }
}
