<?php

namespace App\DTO;

class HistoryPeopleDTO implements DTO
{

    public ?string $firstname;
    public ?string $surname;
    public ?string $patronymic;
    public ?int $auditorium_id;
    public ?array $peoplePositions;

    public function __construct(
        ?string $firstname = null,
        ?string $surname = null,
        ?string $patronymic = null,
        ?int $auditorium_id = null,
        ?array $peoplePositions = null
    )
    {
        $this->firstname = $firstname;
        $this->surname = $surname;
        $this->patronymic = $patronymic;
        $this->auditorium_id = $auditorium_id;
        $this->peoplePositions = $peoplePositions;
    }

    public static function fromArray(array $array) : self {
        return new self(
            $array['firstname'] ?? null,
            $array['surname'] ?? null,
            $array['patronymic'] ?? null,
            $array['auditorium_id'] ?? null,
            $array['peoplePositions'] ?? null
        );
    }

    public function toArray() : array {
        return [
            'firstname' => $this->firstname,
            'surname' => $this->surname,
            'patronymic' => $this->patronymic,
            'auditorium_id' => $this->auditorium_id,
            'peoplePositions' => $this->peoplePositions
        ];
    }
}
