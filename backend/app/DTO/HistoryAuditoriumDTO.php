<?php

namespace App\DTO;

class HistoryAuditoriumDTO implements DTO
{
    public ?int $id;
    public ?string $name;
    public ?string $number;
    public ?int $floor;
    public ?int $branch_id;
    public ?array $auditoriumResponsibilities;
    public function __construct(
        ?int $id = null,
        ?string $name = null,
        ?string $number = null,
        ?int $floor = null,
        ?int $branch_id = null,
        ?array $auditoriumResponsibilities = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->number = $number;
        $this->floor = $floor;
        $this->branch_id = $branch_id;
        $this->auditoriumResponsibilities = $auditoriumResponsibilities;
    }

    public static function fromArray(array $array) : self {
        return new self(
            $array['id'],
            $array['name'],
            $array['number'],
            $array['floor'],
            $array['branch_id'],
            $array['auditorium_responsibilities']
        );
    }

    public function toArray() : array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'number' => $this->number,
            'floor' => $this->floor,
            'branch_id' => $this->branch_id,
            'auditorium_responsibilities' => $this->auditoriumResponsibilities
        ];
    }
}
