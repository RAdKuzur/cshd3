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

    public static function message($index, $url)
    {
        switch ($index) {
            case self::HELLO_EMAIL:
                return '<p>Приветственное сообщение</p>';
            case self::TRANSFER_ACT_CREATE_EMAIL:
                return view('emails.transfer-act-created', ['url' => $url])->render();
            case self::TRANSFER_ACT_UPDATE_EMAIL:
                return view('emails.transfer-act-updated', ['url' => $url])->render();
            case self::TRANSFER_ACT_CONFIRM_CHANGED_EMAIL:
                return view('emails.transfer-act-confirm-changed', ['url' => $url])->render();
            default:
                return '<p>Это сообщение доставлено по ошибке!!! Пожалуйста, обратитесь к администратору</p>';
        }
    }
    public static function get($index){
        return self::type()[$index];
    }
    public static function index($index){
        return array_search($index, self::type());
    }
}
