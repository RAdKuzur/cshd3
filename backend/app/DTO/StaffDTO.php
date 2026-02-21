<?php

namespace App\DTO;

class StaffDTO implements DTO
{
    public ?int $id;
    public ?string $fio;
    public ?string $position;
    public ?string $auditorium;
    public ?string $start_date;
    public ?string $icon_link;


    public function __construct(
        ?int $id = null,
        ?string $fio = null,
        ?string $position = null,
        ?string $auditorium = null,
        ?string $start_date = null,
        ?string $icon_link = null
    )
    {
        $this->id = $id;
        $this->fio = $fio;
        $this->position = $position;
        $this->auditorium = $auditorium;
        $this->start_date = $start_date;
        $this->icon_link = $icon_link;
    }

    public static function fromArray(array $array) : self {
        return new self(
            isset($array['id']) ? (int)$array['id'] : null,
            $array['fio'] ?? null,
            $array['position'] ?? null,
            $array['auditorium'] ?? null,
            $array['start_date'] ?? null,
            $array['icon_link'] ?? null
        );
    }

    public function toArray() : array {
        return [
            'id' => $this->id,
            'fio' => $this->fio,
            'position' => $this->position,
            'auditorium' => $this->auditorium,
            'start_date' => $this->start_date,
            'icon_link' => $this->icon_link
        ];
    }
}
