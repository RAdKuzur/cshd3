<?php

namespace App\Dictionaries;

class RoleDictionary implements BaseDictionary
{
    public const ADMIN = 1;
    public const DIRECTOR = 2;
    public const WORKER = 3;
    public const STUFF_MANAGER = 4;
    public const ACCOUNTANT = 5;

    public static function type(){
        return [
            self::ADMIN => 'Администратор',
            self::DIRECTOR => 'Директор',
            self::WORKER => 'Сотрудник',
            self::STUFF_MANAGER => 'Работник отдела кадров',
            self::ACCOUNTANT => 'Бухгалтер'
        ];
    }
    public static function get($index){
        return self::type()[$index];
    }
    public static function index($index){
        return array_search($index, self::type());
    }
}
