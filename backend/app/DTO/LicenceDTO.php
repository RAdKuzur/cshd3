<?php

namespace App\DTO;

class LicenceDTO implements DTO
{
    public ?string $licenceKey;

    public function __construct(
        ?string $licenceKey = null,
    )
    {
        $this->licenceKey = $licenceKey;
    }

    public static function fromArray(array $array) : self {
        return new self(
            $array['licenceKey'],
        );
    }

    public function toArray() : array {
        return [
            'licence_key' => $this->licenceKey
        ];
    }
}
