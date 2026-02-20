<?php

namespace App\DTO\User;

use App\DTO\DTO;

class UserDTO implements DTO
{
    public ?int $id;
    public ?string $firstname;
    public ?string $surname;
    public ?string $patronymic;
    public ?string $username;
    public ?string $email;
    public ?string $phone;
    public ?string $birthdate;
    public ?int $auditorium_id;
    public ?string $about;
    public ?int $role;
    public function __construct(
        ?int $id = null,
        ?string $firstname = null,
        ?string $surname = null,
        ?string $patronymic = null,
        ?string $username = null,
        ?string $email = null,
        ?string $phone = null,
        ?string $birthdate = null,
        ?int $auditorium_id = null,
        ?string $about = null,
        ?int $role = null
    )
    {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->surname = $surname;
        $this->patronymic = $patronymic;
        $this->username = $username;
        $this->email = $email;
        $this->phone = $phone;
        $this->birthdate = $birthdate;
        $this->auditorium_id = $auditorium_id;
        $this->about = $about;
        $this->role = $role;
    }

    public static function fromArray(array $array) : self {
        return new self(
            isset($array['id']) ? (int)$array['id'] : null,
            isset($array['firstname']) ? (string)$array['firstname'] : null,
            isset($array['surname']) ? (string)$array['surname'] : null,
            isset($array['patronymic']) ? (string)$array['patronymic'] : null,
            isset($array['username']) ? (string)$array['username'] : null,
            isset($array['email']) ? (string)$array['email'] : null,
            isset($array['phone']) ? (string)$array['phone'] : null,
            isset($array['birthdate']) ? (string)$array['birthdate'] : null,
            isset($array['auditorium_id']) ? (int)$array['auditorium_id'] : null,
            isset($array['about']) ? (string)$array['about'] : null,
            isset($array['role']) ? (int)$array['role'] : null,
        );
    }

    public function toArray() : array {
        return [
            'id' => $this->id,
            'firstname' => $this->firstname,
            'surname' => $this->surname,
            'patronymic' => $this->patronymic,
            'username' => $this->username,
            'email' => $this->email,
            'phone' => $this->phone,
            'birthdate' => $this->birthdate,
            'auditorium_id' => $this->auditorium_id,
            'about' => $this->about,
            'role' => $this->role,
        ];
    }
}
