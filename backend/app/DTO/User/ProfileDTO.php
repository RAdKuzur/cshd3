<?php

namespace App\DTO\User;

use App\DTO\DTO;

class ProfileDTO implements DTO
{
    public array $user;

    public function __construct(
        array $user,
    ){
        $this->user = $user;
    }
    public static function fromArray(array $array)
    {
        // TODO: Implement fromArray() method.
        return new self(
            $array['user'],
        );
    }
    public function toArray() : array {
        return [
            'user' => $this->user,
        ];
    }
}
