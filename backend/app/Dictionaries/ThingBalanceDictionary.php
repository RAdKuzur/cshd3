<?php

namespace App\Dictionaries;

class ThingBalanceDictionary implements BaseDictionary
{

    public const OS = 1;
    public const BALANCE = 2;

    public static function type(){
        return [
            self::OS => 'Основное средство',
            self::BALANCE => 'За балансом'
        ];
    }
    public static function get($index){
        return self::type()[$index];
    }

}
