<?php

namespace App\Dictionaries;

class ThingBalanceDictionary implements BaseDictionary
{
    public const NONE_BALANCE = 1;
    public const OS = 2;
    public const BALANCE = 3;
    public const RESOURCE = 4;
    public const DESTROYED = 5;

    public static function type(){
        return [
            self::NONE_BALANCE => 'Не состоит на балансе в организации',
            self::OS => 'Основное средство',
            self::BALANCE => 'За балансом',
            self::RESOURCE => 'Расходный материал',
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
