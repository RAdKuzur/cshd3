<?php

namespace App\Dictionaries;

class EmailDictionary implements BaseDictionary
{

    public const HELLO_EMAIL = 1;

    public static function type(){
        return [
            self::HELLO_EMAIL => '<p>Приветственное сообщение</p>',
        ];
    }
    public static function get($index){
        return self::type()[$index];
    }
    public static function index($index){
        return array_search($index, self::type());
    }
}
