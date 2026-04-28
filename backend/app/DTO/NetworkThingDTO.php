<?php

namespace App\DTO;

class NetworkThingDTO implements DTO
{
    public ?int $id;

    public ?int $thing_id;
    public ?string $ip_address;
    public ?string $domain;
    public ?string $phone_number;
    public ?string $comment;
    public ?string $inv_number;
    public ?int $type;
    public ?int $auditorium_id;
    public function __construct(
        ?int $id = null,
        ?int $thing_id = null,
        ?string $ip_address = null,
        ?string $domain = null,
        ?string $phone_number = null,
        ?string $comment = null,
        ?string $inv_number = null,
        ?int $type = null,
        ?int $auditorium_id = null
    ){
        $this->id = $id;
        $this->thing_id = $thing_id;
        $this->ip_address = $ip_address;
        $this->domain = $domain;
        $this->phone_number = $phone_number;
        $this->comment = $comment;
        $this->inv_number = $inv_number;
        $this->type = $type;
        $this->auditorium_id = $auditorium_id;
    }
    public static function fromArray(array $array)
    {
        // TODO: Implement fromArray() method.
        return new self(
            $array['id'],
            $array['thing_id'],
            $array['ip_address'],
            $array['domain'],
            $array['phone_number'],
            $array['comment'],
            $array['inv_number'],
            $array['type'],
            $array['auditorium_id'],
        );
    }
    public function toArray() : array {
        return [
            'thing_id' => $this->thing_id,
            'ip_address' => $this->ip_address,
            'domain' => $this->domain,
            'phone_number' => $this->phone_number,
            'comment' => $this->comment
        ];
    }

    public function toSearchArray(): array {
        return [
            'IP Адрес' => $this->ip_address,
            'Номер телефона' => $this->phone_number,
            'Комментарий' => $this->comment,
        ];
    }
    public function toSearchString(): string {
        return $this->comment;
    }
}
