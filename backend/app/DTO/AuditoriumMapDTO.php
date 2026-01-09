<?php

namespace App\DTO;

class AuditoriumMapDTO implements DTO
{
    public int $auditorium_id;
    public string $auditorium_name;
    public string $comment;
    public int $floor;
    public int $branch_id;
    public array $things;
    public array $employees;
    public function __construct(
        int $auditorium_id,
        string $auditorium_name,
        string $comment,
        int $floor,
        int $branch_id,
        array $things,
        array $employees
    ){
        $this->auditorium_id = $auditorium_id;
        $this->auditorium_name = $auditorium_name;
        $this->comment = $comment;
        $this->floor = $floor;
        $this->branch_id = $branch_id;
        $this->things = $things;
        $this->employees = $employees;
    }
    public static function fromArray(array $array)
    {
        // TODO: Implement fromArray() method.
        return new self(
            $array['auditorium_id'],
            $array['auditorium_name'],
            $array['comment'],
            $array['floor'],
            $array['branch_id'],
            $array['things'],
            $array['employees']
        );
    }
    public function toArray() : array {
        return [
            'auditorium_id' => $this->auditorium_id,
            'auditorium_name' => $this->auditorium_name,
            'comment' => $this->comment,
            'floor' => $this->floor,
            'branch_id' => $this->branch_id,
            'things' => $this->things,
            'employees' => $this->employees
        ];
    }
}
