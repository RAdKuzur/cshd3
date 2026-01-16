<?php

namespace App\Dictionaries;

class EmailDictionary implements BaseDictionary
{

    public const HELLO_EMAIL = 1;
    public const TRANSFER_ACT_CREATE_EMAIL = 2;
    public const TRANSFER_ACT_CONFIRM_CHANGED_EMAIL = 3;
    public const TRANSFER_ACT_UPDATE_EMAIL = 4;

    public static function type(){
        return [
            self::HELLO_EMAIL => '<p>Приветственное сообщение</p>',
            self::TRANSFER_ACT_CREATE_EMAIL => '<p>Акт приёма/передачи/списания создан</p>',
            self::TRANSFER_ACT_CONFIRM_CHANGED_EMAIL => '<p>Изменилось подтверждение в одном из актов материального перемещения</p>',
            self::TRANSFER_ACT_UPDATE_EMAIL => '<p>Акт приёма/передачи/списания был изменён</p>'
        ];
    }
    public static function get($index){
        return self::type()[$index];
    }
    public static function index($index){
        return array_search($index, self::type());
    }
}
