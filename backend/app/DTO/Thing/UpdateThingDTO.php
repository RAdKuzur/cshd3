<?php

namespace App\DTO\Thing;

use App\DTO\DTO;
use App\DTO\Thing\ThingChildDTO;

class UpdateThingDTO implements DTO
{
    /**
     * @param ThingChildDTO[] $childrenToCreate
     * @param int[] $childrenToDelete
     */
    public function __construct(
        public readonly ?string $name,
        public readonly ?string $second_name,
        public readonly ?string $inv_number,
        public readonly ?string $serial_number,
        public readonly ?string $operation_date,
        public readonly ?int $condition = null,
        public readonly ?string $comment = null,
        public readonly ?float $price = null,
        public readonly ?int $thing_type_id = null,
        public readonly array $childrenToCreate = [],
        public readonly array $childrenToDelete = [],
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'] ?? null,
            second_name: $data['second_name'] ?? null,
            inv_number: $data['inv_number'] ?? null,
            serial_number: $data['serial_number'] ?? null,
            operation_date: $data['operation_date'] ?? null,
            condition: $data['condition'] ?? null,
            comment: $data['comment'] ?? null,
            price: $data['price'] ?? null,
            thing_type_id: $data['thing_type_id'] ?? null,
            childrenToCreate: self::mapChildren($data['children']['create'] ?? []),
            childrenToDelete: $data['children']['delete'] ?? [],
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
            'inv_number' => $this->inv_number,
            'serial_number' => $this->serial_number,
            'operation_date' => $this->operation_date,
            'condition' => $this->condition,
            'comment' => $this->comment,
            'price' => $this->price,
            'thing_type_id' => $this->thing_type_id,
        ];
    }
    public function toSearchString(): string {
        return $this->comment;
    }
}
