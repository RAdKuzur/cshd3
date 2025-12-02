<?php

namespace App\Dictionaries;

use function Symfony\Component\String\s;

class ThingTypeDictionary
{
    public const ARM = 0;
    public const PC = 1;
    public const MONITOR = 2;
    public const PRINTER = 3;
    public const MFU = 4;
    public const IBP = 5;
    public const KMA = 6;
    public const SCANNER = 7;
    public const MONOPC = 8;
    public const PASSPORT_SCANNER = 9;
    public const CARD_PRINTER = 10;
    public const ELECTRONICS = [
        self::ARM,self::PC,self::MONITOR,self::PRINTER,
        self::MFU,self::IBP,self::KMA,self::SCANNER,
        self::MONOPC,self::PASSPORT_SCANNER, self::CARD_PRINTER,
    ];
    public static function type(){
        return [
            self::ARM => 'АРМ',
            self::PC => 'Системный блок',
            self::MONITOR => 'Монитор',
            self::PRINTER => 'Принтер',
            self::MFU => 'МФУ',
            self::IBP => 'ИБП',
            self::KMA => 'КМА',
            self::SCANNER => 'Сканер',
            self::MONOPC => 'Моноблок',
            self::PASSPORT_SCANNER => 'Сканер паспортов',
            self::CARD_PRINTER => 'Принтер для карточек',
        ];
    }
    public static function indexElectronics($index){
        return array_search($index, self::type());
    }
}
