<?php

namespace App\DTO;

class AuditoriumDTO implements DTO
{
    public ?int $id;
    public ?string $name;
    public ?string $number;
    public ?int  $floor;
    public ?int $department_id;
    public ?int $branch_id;
    public ?string $comment;

    public function __construct(
        ?int $id = null,
        ?string $name = null,
        ?string $number = null,
        ?int $floor = null,
        ?int $department_id = null,
        ?int $branch_id = null,
        ?string $comment = null
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->number = $number;
        $this->floor = $floor;
        $this->department_id = $department_id;
        $this->branch_id = $branch_id;
        $this->comment = $comment;
    }

    public static function fromArray(array $array) : self {
        return new self(
          $array['name'] ?? null,
            $array['number'] ?? null,
            $array['floor'] ?? null,
            $array['department_id'] ?? null,
            $array['branch_id'] ?? null,
            $array['comment'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'number' => $this->number,
            'floor' => $this->floor,
            'department_id' => $this->department_id,
            'branch_id' => $this->branch_id,
            'comment' => $this->comment
        ];
    }

}
