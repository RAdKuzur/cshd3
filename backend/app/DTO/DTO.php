<?php

namespace App\DTO;

interface DTO
{
    public static function fromArray(array $array);
    public function toArray() : array;

}
