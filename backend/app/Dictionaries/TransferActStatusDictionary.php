<?php

namespace App\Dictionaries;


class TransferActStatusDictionary implements BaseDictionary
{
    public const NOT_CONFIRMED = 1;
    public const CONFIRMED = 2;
    public const AWAITING = 3;

    public static function type(){
        return [
            self::NOT_CONFIRMED => 'Не подтверждено',
            self::CONFIRMED => 'Подтверждено',
            self::AWAITING => 'В ожидании'
        ];
    }

    public static function get($index){
        return self::type()[$index];
    }
    public static function index($index){
        return array_search($index, self::type());
    }
}
