<?php

namespace App\DTO;

class NetworkThingDTO implements DTO
{
    public ?int $id;

    public ?int $thing_id;
    public ?string $ip_address;
    public ?string $phone_number;
    public ?string $comment;
    public function __construct(
        ?int $id = null,
        ?int $thing_id = null,
        ?string $ip_address = null,
        ?string $phone_number = null,
        ?string $comment = null
    ){
        $this->id = $id;
        $this->thing_id = $thing_id;
        $this->ip_address = $ip_address;
        $this->phone_number = $phone_number;
        $this->comment = $comment;
    }
    public static function fromArray(array $array)
    {
        // TODO: Implement fromArray() method.
        return new self(
            $array['id'],
            $array['thing_id'],
            $array['ip_address'],
            $array['phone_number'],
            $array['comment']
        );
    }
    public function toArray() : array {
        return [
            'thing_id' => $this->thing_id,
            'ip_address' => $this->ip_address,
            'phone_number' => $this->phone_number,
            'comment' => $this->comment
        ];
    }
}
