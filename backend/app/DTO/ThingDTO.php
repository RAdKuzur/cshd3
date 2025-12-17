<?php

namespace App\DTO;

use Carbon\Carbon;

class ThingDTO implements DTO
{
    /**
     * @param ThingChildDTO[] $children
     */
    public function __construct(
        public readonly ?string $id = null,
        public readonly ?string $name = null,
        public readonly ?string $serial_number = null,
        public readonly ?string $inv_number= null,
        public readonly ?Carbon $operation_date = null,
        public readonly ?int $thing_type_id= null,
        public readonly ?int $condition = null,
        public readonly ?float $balance = null,
        public readonly ?int $auditorium_id = null,
        public readonly ?float $price = null,
        public readonly ?string $comment = null,
        public readonly ?bool $is_composite = null,
        public readonly ?array $children = [],
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'],
            $data['serial_number'] ?? null,
            $data['inv_number'] ?? null,
            Carbon::parse($data['operation_date']),
            $data['thing_type_id'],
            $data['condition'],
            (float)$data['balance'],
            $data['auditorium_id'],
            isset($data['price']) ? (float)$data['price'] : null,
            $data['comment'] ?? null,
            (bool)$data['is_composite'],
            self::mapChildren($data['children'] ?? []),
        );
    }

    /**
     * @return ThingChildDTO[]
     */
    private static function mapChildren(array $children): array
    {
        return array_map(
            fn(array $child) => ThingChildDTO::fromArray($child),
            $children
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'serial_number' => $this->serial_number,
            'inv_number' => $this->inv_number,
            'operation_date' => $this->operation_date->toDateString(),
            'thing_type_id' => $this->thing_type_id,
            'condition' => $this->condition,
            'balance' => $this->balance,
            'price' => $this->price,
            'comment' => $this->comment,
            'is_composite' => $this->is_composite,
        ];
    }
}
