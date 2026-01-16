<?php

namespace App\Dictionaries;

use function Symfony\Component\String\s;

class NotificationTypeDictionary implements BaseDictionary
{
    public const TRANSFER_ACT_CREATE = 1;
    public const TRANSFER_ACT_CONFIRM = 2;
    public const TRANSFER_ACT_UPDATE = 3;

    public static function type(){
        return [
            self::TRANSFER_ACT_CREATE => 'Был создан акт материального перемещения',
            self::TRANSFER_ACT_CONFIRM => 'Статус акта материального перемещения изменился',
            self::TRANSFER_ACT_UPDATE => 'Был изменён акт материального перемещения'
        ];
    }
    public static function get($index){
        return self::type()[$index];
    }
    public static function index($index){
        return array_search($index, self::type());
    }
}
