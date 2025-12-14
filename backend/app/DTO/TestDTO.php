<?php

namespace App\DTO;

class TestDTO implements DTO
{
    public string $email;
    public string $username;
    public int $number;

    public function __construct(
        string $email,
        string $username,
        int $number
    )
    {
        $this->email = $email;
        $this->username = $username;
        $this->number = $number;
    }

    public function fromArray(array $array) : self {
        return new self(
            $array['email'],
            $array['username'],
            $array['number']
        );
    }

    public function toArray() : array {
        return [
            'email' => $this->email,
            'username' => $this->username,
            'number' => $this->number
        ];
    }
}
