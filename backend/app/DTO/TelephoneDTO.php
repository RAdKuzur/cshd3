<?php

namespace App\DTO;

class TelephoneDTO implements DTO
{
    public ?int $id;
    public ?string $phone_number;
    public ?int $auditorium_id;
    public ?int $thing_id;

    public function __construct(
        ?int $id = null,
        ?string $phone_number = null,
        ?int $auditorium_id = null,
        ?int $thing_id = null
    ){
        $this->id = $id;
        $this->phone_number = $phone_number;
        $this->auditorium_id = $auditorium_id;
        $this->thing_id = $thing_id;
    }
    public static function fromArray(array $array)
    {
        return new self(
            isset($array['id']) ?? null,
            isset($array['phone_number']) ?? null,
            isset($array['auditorium_id']) ?? null,
            isset($array['thing_id']) ?? null
        );
    }
    public function toArray() : array {
        return [
            'id' => $this->id,
            'phone_number' => $this->phone_number,
            'auditorium_id' => $this->auditorium_id,
            'thing_id' => $this->thing_id
        ];
    }
}
