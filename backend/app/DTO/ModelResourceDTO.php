<?php

namespace App\DTO;

class ModelResourceDTO implements DTO
{
    public ?int $id;
    public ?int $model_id;
    public ?int $resource_id;
    public function __construct(
        ?int $id = null,
        ?int $model_id = null,
        ?int $resource_id = null
    )
    {
        $this->id = $id;
        $this->model_id = $model_id;
        $this->resource_id = $resource_id;
    }

    public static function fromArray(array $array) : self {
        return new self(
            $array['id'],
            $array['model_id'],
            $array['resource_id']
        );
    }

    public function toArray() : array {
        return [
            'model_id' => $this->model_id,
            'resource_id' => $this->resource_id
        ];
    }
}
