<?php

namespace App\Dictionaries;

class NotificationTypeDictionary implements BaseDictionary
{
    public const TRANSFER_ACT = 1;

    public static function type(){
        return [
            self::TRANSFER_ACT => 'Был создан акт материального перемещения',
        ];
    }
    public static function get($index){
        return self::type()[$index];
    }
    public static function index($index){
        return array_search($index, self::type());
    }
}
