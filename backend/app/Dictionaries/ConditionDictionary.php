<?php

namespace App\Dictionaries;

class ConditionDictionary implements BaseDictionary
{
    public const OK = 0;
    public const BROKEN = 1;

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
