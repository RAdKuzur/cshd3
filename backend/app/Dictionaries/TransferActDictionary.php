<?php

namespace App\Dictionaries;

class TransferActDictionary implements BaseDictionary
{
    public const ENROLL = 1;
    public const TRANSFER = 2;
    public const DESTROY = 3;

    public static function type(){
        return [
            self::ENROLL => 'Акт о приёме мат.средств',
            self::TRANSFER => 'Акт о приёме/передаче мат.средств',
            self::DESTROY => 'Акт о списании материальных средств',
        ];
    }

    public static function get($index){
        return self::type()[$index];
    }
    public static function index($index){
        return array_search($index, self::type());
    }
}
