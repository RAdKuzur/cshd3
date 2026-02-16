<?php

namespace App\DTO;

class HistoryResourceDTO implements DTO
{

    public ?int $id;
    public ?int $resource_id;
    public ?int $amount;

    public function __construct(
        ?int $id = null,
        ?int $resource_id = null,
        ?int $amount = null
    )
    {
        $this->id = $id;
        $this->resource_id = $resource_id;
        $this->amount = $amount;
    }

    public static function fromArray(array $array) : self {
        return new self(
            $array['id'],
            $array['resource_id'],
            $array['amount']
        );
    }

    public function toArray() : array {
        return [
            'resource_id' => $this->resource_id,
            'amount' => $this->amount
        ];
    }
}
