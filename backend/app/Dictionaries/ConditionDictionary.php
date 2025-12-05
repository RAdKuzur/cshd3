<?php

namespace App\Dictionaries;

class ConditionDictionary implements BaseDictionary
{
    public const OK = 1;
    public const BROKEN = 2;

    public static function type(): array
    {
        return [
            self::OK => 'Исправно работает',
            self::BROKEN => 'Сломано',
        ];
    }
    public static function get($index){
        return self::type()[$index];
    }
}
