<?php

namespace App\DTO;

class TechWorkDTO implements DTO
{
    public ?int $id;
    public $startTime;
    public $endTime;
    public ?int $status;

    public function __construct(
        ?int $id = null,
        $startTime = null,
        $endTime = null,
        ?int $status = null
    )
    {
        $this->id = $id;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->status = $status;
    }

    public static function fromArray(array $array) : self {
        return new self(
            $array['startTime'],
            $array['endTime'],
            $array['status']
        );
    }

    public function toArray() : array {
        return [
            'start_time' => $this->startTime,
            'end_time' => $this->endTime,
            'status' => $this->status
        ];
    }
}
