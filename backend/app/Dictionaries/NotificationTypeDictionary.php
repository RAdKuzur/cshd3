<?php

namespace App\Dictionaries;

use function Symfony\Component\String\s;

class NotificationTypeDictionary implements BaseDictionary
{
    public const TRANSFER_ACT = 1;
    public const TRANSFER_ACT_CONFIRM = 2;

    public static function type(){
        return [
            self::TRANSFER_ACT => 'Был создан акт материального перемещения',
            self::TRANSFER_ACT_CONFIRM => 'Статус акта материального перемещения изменился'
        ];
    }
    public static function get($index){
        return self::type()[$index];
    }
    public static function index($index){
        return array_search($index, self::type());
    }
}
