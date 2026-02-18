<?php

namespace App\DTO;

class ChangePasswordDTO implements DTO
{
    public ?string $email;
    public ?string $password;
    public ?string $confirmPassword;
    public function __construct(
        ?string $email = null,
        ?string $password = null,
        ?string $confirmPassword = null
    ){
        $this->email = $email;
        $this->password = $password;
        $this->confirmPassword = $confirmPassword;
    }
    public static function fromArray(array $array)
    {
        return new self(
            $array['email'] ?? null,
            $array['password'] ?? null,
            $array['confirmPassword'] ?? null
        );
    }
    public function toArray() : array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
            'confirmPassword' => $this->confirmPassword
        ];
    }
}
