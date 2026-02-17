<?php

namespace App\DTO;

class HistoryThingDTO implements DTO
{
    public ?int $id;
    public ?string $name;
    public ?string $inv_number;
    public ?int $type;
    public ?array $thingAuditoriums;

    public function __construct(
        ?int $id = null,
        ?string $name = null,
        ?string $inv_number = null,
        ?int $type = null,
        ?array $thingAuditoriums = [],
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->inv_number = $inv_number;
        $this->type = $type;
        $this->thingAuditoriums = $thingAuditoriums;
    }

    public static function fromArray(array $array) : self {
        return new self(
            $array['id'],
            $array['name'],
            $array['inv_number'],
            $array['type'],
            $array['thingAuditoriums'],
        );
    }

    public function toArray() : array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'inv_number' => $this->inv_number,
            'type' => $this->type,
            'thingAuditoriums' => $this->thingAuditoriums,
        ];
    }
}
