<?php

namespace App\DTO;

class PeoplePositionDTO implements DTO
{
    public ?int $id;
    public ?int $people_id;
    public ?int $position_id;
    public ?int $branch_id;
    public $start_date;
    public $end_date;

    public function __construct(
        ?int $id = null,
        ?int $people_id = null,
        ?int $position_id = null,
        ?int $branch_id = null,
        ?string $start_date = null,
        ?string $end_date = null
    )
    {
        $this->id = $id;
        $this->people_id = $people_id;
        $this->position_id = $position_id;
        $this->branch_id = $branch_id;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public static function fromArray(array $array) : self {
        return new self(
            $array['id'],
            $array['people_id'],
            $array['position_id'],
            $array['branch_id'],
            $array['start_date'],
            $array['end_date']
        );
    }

    public function toArray() : array {
        return [
            'people_id' => $this->people_id,
            'position_id' => $this->position_id,
            'branch_id' => $this->branch_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date
        ];
    }
}
