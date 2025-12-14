<?php

namespace App\DTO;

interface DTO
{
    public function fromArray(array $array);
    public function toArray() : array;

}
