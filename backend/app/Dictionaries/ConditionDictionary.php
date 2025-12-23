<?php

namespace App\Dictionaries;

use function Symfony\Component\String\s;

class ConditionDictionary implements BaseDictionary
{
    public const NONE_BALANCE = 1;
    public const OK = 2;
    public const BROKEN = 3;
    public const LOST = 4;
    public const BEFORE_DESTROY = 5;
    public const DESTROYED = 6;
    public static function type(): array
    {
        return [
            self::NONE_BALANCE => 'Не состоит на балансе в организации',
            self::OK => 'Исправно работает',
            self::BROKEN => 'Сломано',
            self::LOST => 'Утерян',
            self::BEFORE_DESTROY => 'На списание',
            self::DESTROYED => 'Списано'
        ];
    }
    public static function get($index){
        return self::type()[$index];
    }
    public static function index($index){
        return array_search($index, self::type());
    }
}
