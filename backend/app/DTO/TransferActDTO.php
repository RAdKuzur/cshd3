<?php

namespace App\DTO;

use App\Models\TransferAct;

class TransferActDTO implements DTO
{
    public ?int $id;
    public ?int $from;
    public ?int $to;
    public $time;
    public ?int $type;
    public ?int $confirmed;
    public ?array $things;

    public function __construct(
        ?int $id = null,
        ?int $from = null,
        ?int $to = null,
             $time = null,
        ?int $type = null,
        ?int $confirmed = null,
        ?array $things = null
    ){
        $this->id = $id;
        $this->from = $from;
        $this->to = $to;
        $this->time = $time;
        $this->type = $type;
        $this->confirmed = $confirmed;
        $this->things = $things;
    }

    public static function fromArray(array $array)
    {
        return new self(
            $array['id'] ?? null,
            isset($array['from']) ? (int)$array['from'] : null,
            isset($array['to']) ? (int)$array['to'] : null,
            $array['time'] ?? null,
            isset($array['type']) ? (int)$array['type'] : null,
            isset($array['confirmed']) ? (int)$array['confirmed'] : null,
            isset($array['things']) ? (int)$array['things'] : null,
        );
    }
    public static function fromModel(TransferAct $transferAct)
    {
        return new self(
            $transferAct->id,
            $transferAct->from,
            $transferAct->to,
            $transferAct->time,
            $transferAct->type,
            $transferAct->confirmed,
            $transferAct->transferActThings()->pluck('thing_id')->toArray() // что-то страшное :(
        );
    }

    public function toArray() : array {
        return [
            'from' => $this->from,
            'to' => $this->to,
            'time' => $this->time,
            'type' => $this->type,
            'confirmed' => $this->confirmed
        ];
    }
}
