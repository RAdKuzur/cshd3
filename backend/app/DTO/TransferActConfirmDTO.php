<?php

namespace App\DTO;

use App\Models\TransferActConfirm;

class TransferActConfirmDTO implements DTO
{
    public ?int $id;
    public ?int $transfer_act_id;
    public ?int $people_position_id;
    public ?int $status;
    public ?int $people_id;

    public function __construct(
        ?int $id = null,
        ?int $transfer_act_id = null,
        ?int $people_position_id = null,
        ?int $status = null,
        ?int $people_id = null,
    ){
        $this->id = $id;
        $this->transfer_act_id = $transfer_act_id;
        $this->people_position_id = $people_position_id;
        $this->status = $status;
        $this->people_id = $people_id;
    }
    public static function fromArray(array $array)
    {
        // TODO: Implement fromArray() method.
        return new self(
            isset($array['id']) ? (int)$array['id'] : null,
            isset($array['transfer_act_id']) ? (int)$array['transfer_act_id'] : null,
            isset($array['people_position_id']) ? (int)$array['people_position_id'] : null,
            isset($array['status']) ? (int)$array['status'] : null,
            isset($array['people_id']) ? (int)$array['people_id'] : null,
        );
    }
    public static function fromModel(TransferActConfirm $model): self{
        return new self(
            $model->id,
            $model->transfer_act_id,
            $model->people_position_id,
            $model->status,
        );
    }
    public function toArray() : array {
        return [
            'id' => $this->id,
            'transfer_act_id' => $this->transfer_act_id,
            'people_position_id' => $this->people_position_id,
            'status' => $this->status
        ];
    }
}
