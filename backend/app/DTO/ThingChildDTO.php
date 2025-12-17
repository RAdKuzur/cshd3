<?php

namespace App\DTO;

class ThingChildDTO implements DTO
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $serial_number,
        public readonly ?string $inv_number,
        public readonly int $thing_type_id,
        public readonly ?float $price,
        public readonly ?int $condition,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'],
            $data['serial_number'] ?? null,
            $data['inv_number'] ?? null,
            $data['thing_type_id'],
            isset($data['price']) ? (float)$data['price'] : null,
            $data['condition'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'serial_number' => $this->serial_number,
            'inv_number' => $this->inv_number,
            'thing_type_id' => $this->thing_type_id,
            'price' => $this->price,
            'condition' => $this->condition,
        ];
    }
}
