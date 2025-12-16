<?php

namespace App\DTO;

use App\Models\People;

class PeopleDTO implements DTO
{
    public ?int $id;
    public ?string $firstname;
    public ?string $surname;
    public ?string $patronymic;
    public function __construct(
        ?int $id = null,
        ?string $firstname = null,
        ?string $surname = null,
        ?string $patronymic = null


    ){
        $this->id = $id;
        $this->firstname = $firstname;
        $this->surname = $surname;
        $this->patronymic = $patronymic;
    }
    public static function fromArray(array $array)
    {
        // TODO: Implement fromArray() method.
        return new self(
            $array['id'],
            $array['firstname'],
            $array['surname'],
            $array['patronymic'],
        );
    }
    public static function fromModel(People $model): self{
        return new self(
            $model->id,
            $model->firstname,
            $model->surname,
            $model->patronymic,
        );
    }
    public function toArray() : array {
        return [
            'id' => $this->id,
            'firstname' => $this->firstname,
            'surname' => $this->surname,
            'patronymic' => $this->patronymic,
        ];
    }
}
