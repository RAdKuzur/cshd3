<?php

namespace App\DTO;

class DeviceDTO implements DTO
{
    public ?int $id;
    public ?int $model_id;
    public ?int $thing_id;
    public function __construct(
        ?int $id = null,
        ?int $model_id = null,
        ?int $thing_id = null,
    )
    {
        $this->id = $id;
        $this->model_id = $model_id;
        $this->thing_id = $thing_id;
    }

    public static function fromArray(array $array) : self {
        return new self(
            $array['id'],
            $array['model_id'],
            $array['thing_id'],
        );
    }

    public function toArray() : array {
        return [
            'model_id' => $this->model_id,
            'thing_id' => $this->thing_id,
        ];
    }
}
