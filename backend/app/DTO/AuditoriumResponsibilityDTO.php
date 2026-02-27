<?php

namespace App\DTO;

class AuditoriumResponsibilityDTO implements DTO
{
    public ?int $id;
    public ?int $people_id;
    public ?int $auditorium_id;
    public $start_date;
    public $end_date;

    public function __construct(
        ?int $id = null,
        ?int $people_id = null,
        ?int $auditorium_id = null,
             $start_date = null,
             $end_date = null
    )
    {
        $this->id = $id;
        $this->people_id = $people_id;
        $this->auditorium_id = $auditorium_id;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public static function fromArray(array $array) : self {
        return new self(
            $array['id'],
            $array['people_id'],
            $array['auditorium_id'],
            $array['start_date'],
            $array['end_date']
        );
    }

    public function toArray() : array {
        return [
            'people_id' => $this->people_id,
            'auditorium_id' => $this->auditorium_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date
        ];
    }
}
