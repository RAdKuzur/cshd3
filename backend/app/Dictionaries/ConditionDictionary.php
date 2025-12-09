<?php

namespace App\Dictionaries;

use function Symfony\Component\String\s;

class ConditionDictionary implements BaseDictionary
{
    public const OK = 1;
    public const BROKEN = 2;
    public const LOST = 3;
    public const BEFORE_DESTROY = 4;
    public static function type(): array
    {
        return [
            self::OK => 'Исправно работает',
            self::BROKEN => 'Сломано',
            self::LOST => 'Утерян',
            self::BEFORE_DESTROY => 'На списание',
        ];
    }
    public static function get($index){
        return self::type()[$index];
    }
    public static function index($index){
        return array_search($index, self::type());
    }
}
