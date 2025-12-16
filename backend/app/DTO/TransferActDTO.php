<?php

namespace App\DTO;

use App\Models\TransferAct;

class TransferActDTO implements DTO
{
    public int $id;
    public int $from;
    public int $to;
    public $time;
    public int $type;
    public int $confirmed;
    public function __construct(int $id, string $from, int $to, $time, int $type, int $confirmed){
        $this->id = $id;
        $this->from = $from;
        $this->to = $to;
        $this->time = $time;
        $this->type = $type;
        $this->confirmed = $confirmed;
    }
    public static function fromArray(array $array)
    {
        // TODO: Implement fromArray() method.
        return new self(
            $array['id'],
            $array['from'],
            $array['to'],
            $array['time'],
            $array['type'],
            $array['confirmed'],
        );
    }
    public static function fromModel(TransferAct $transferAct){
        return new self(
            $transferAct->id,
            $transferAct->from,
            $transferAct->to,
            $transferAct->time,
            $transferAct->type,
            $transferAct->confirmed,
        );
    }
    public function toArray() : array {
        return [
            'id' => $this->id,
            'from' => $this->from,
            'to' => $this->to,
            'time' => $this->time,
            'type' => $this->type,
            'confirmed' => $this->confirmed
        ];
    }
}
