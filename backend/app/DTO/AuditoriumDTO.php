<?php

namespace App\DTO;

class AuditoriumDTO implements DTO
{
    public string $name;
    public string $number;
    public int  $floor;
    public string $department_id;
    public string $branch_id;

    public function __construct(
        string $name,
        string $number,
        int $floor,
        string $department_id,
        string $branch_id
    )
    {
        $this->name = $name;
        $this->number = $number;
        $this->floor = $floor;
        $this->department_id = $department_id;
        $this->branch_id=$branch_id;
    }

    public static function fromArray(array $array) : self {
        return new self(
          $array['name'],
          $array['number'],
          $array['floor'],
          $array['department_id'],
          $array['branch_id']
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'number' => $this->number,
            'floor' => $this->floor,
            'department_id' => $this->department_id,
            'branch_id' => $this->branch_id
        ];
    }

}
