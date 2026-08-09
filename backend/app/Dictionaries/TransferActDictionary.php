<?php

namespace App\Dictionaries;

class TransferActDictionary implements BaseDictionary
{
    public const ENROLL = 1;
    public const TRANSFER = 2;
    public const DESTROY = 3;
    public const ENROLL_BALANCE = 4;
    public const ENROLL_RESOURCE = 5;
    public const ENROLL_TEMPORARY = 6;

    public static function type(){
        return [
            self::ENROLL => 'Акт о приёме мат.средств (Основные средства)',
            self::TRANSFER => 'Акт о приёме/передаче мат.средств',
            self::DESTROY => 'Акт о списании материальных средств',
            self::ENROLL_BALANCE => 'Акт о приёме мат.средств (Баланс)',
            self::ENROLL_RESOURCE => 'Акт о приёме мат.средств (Расходные материалы)',
            self::ENROLL_TEMPORARY => 'Акт о приёме мат.средств (Временное хранение)'
        ];
    }

    public static function transferToBalanceType($type)
    {
        return match ($type) {
            self::ENROLL => ThingBalanceDictionary::OS,
            self::ENROLL_BALANCE => ThingBalanceDictionary::BALANCE,
            self::ENROLL_RESOURCE => ThingBalanceDictionary::RESOURCE,
            self::DESTROY => ThingBalanceDictionary::DESTROYED,
            self::ENROLL_TEMPORARY => ThingBalanceDictionary::TEMPORARY,
            default => false,
        };
    }

    public static function revertToBalanceType($type)
    {
        return match ($type) {
            self::ENROLL, self::ENROLL_BALANCE, self::ENROLL_RESOURCE, self::ENROLL_TEMPORARY => ThingBalanceDictionary::NONE_BALANCE,
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
