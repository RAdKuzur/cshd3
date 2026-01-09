<?php

namespace App\Dictionaries;

use function Symfony\Component\String\s;

class TransferActDictionary implements BaseDictionary
{
    public const ENROLL = 1;
    public const TRANSFER = 2;
    public const DESTROY = 3;
    public const ENROLL_BALANCE = 4;
    public const ENROLL_RESOURCE = 5;


    public static function type(){
        return [
            self::ENROLL => 'Акт о приёме мат.средств (Основные средства)',
            self::TRANSFER => 'Акт о приёме/передаче мат.средств',
            self::DESTROY => 'Акт о списании материальных средств',
            self::ENROLL_BALANCE => 'Акт о приёме мат.средств (Баланс)',
            self::ENROLL_RESOURCE => 'Акт о приёме мат.средств (Расходные материалы)',
        ];
    }

    public static function transferToBalanceType($type)
    {
        return match ($type) {
            self::ENROLL => ThingBalanceDictionary::OS,
            self::ENROLL_BALANCE => ThingBalanceDictionary::BALANCE,
            self::ENROLL_RESOURCE => ThingBalanceDictionary::RESOURCE,
            self::DESTROY => ThingBalanceDictionary::DESTROYED,
            default => false,
        };
    }

    public static function revertToBalanceType($type)
    {
        return match ($type) {
            self::ENROLL, self::ENROLL_BALANCE, self::ENROLL_RESOURCE => ThingBalanceDictionary::NONE_BALANCE,
            default => false,
        };
    }

    public static function get($index){
        return self::type()[$index];
    }
    public static function index($index){
        return array_search($index, self::type());
    }
}
