<?php

namespace App\Dictionaries;

use function Symfony\Component\String\s;

class ThingTypeDictionary implements BaseDictionary
{
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
    public const ARM = 11;
    public const VCN = 12;
    public const RADIO_SYSTEM = 13;
    public const GRAPH_PANEL = 14;
    public const FAX = 15;
    public const SERVER = 16;
    public const NETWORK_BORDER = 17;
    public const TELEPHONE = 18;
    public const STORAGE = 19;
    public const CAMERA = 20;
    public const COMMUTATOR = 21;
    public const TV = 22;
    public const SOUNDBAR = 23;
    public const BATTERY = 24;
    public const HEADSET = 25;
    public const OTHER = 26;
    public const ELECTRONICS = [
        self::PC,               // 1
        self::MONITOR,          // 2
        self::PRINTER,          // 3
        self::MFU,              // 4
        self::IBP,              // 5
        self::KMA,              // 6
        self::SCANNER,          // 7
        self::MONOPC,           // 8
        self::PASSPORT_SCANNER, // 9
        self::CARD_PRINTER,     // 10
        self::ARM,              // 11
        self::VCN,              // 12
        self::RADIO_SYSTEM,    // 13
        self::GRAPH_PANEL,      // 14
        self::FAX,              // 15
        self::SERVER,           // 16
        self::NETWORK_BORDER,   // 17
        self::TELEPHONE,        // 18
        self::STORAGE,          // 19
        self::CAMERA,           // 20
        self::COMMUTATOR,       // 21
        self::TV,               // 22
        self::SOUNDBAR,         // 23
        self::BATTERY,          // 24
        self::HEADSET,          // 25
        //без self::OTHER
    ];
    public static function type(){
        return [
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
            self::ARM => 'АРМ',
            self::VCN => 'Видеоконференцсвязь',
            self::RADIO_SYSTEM => 'Радиосистема',
            self::GRAPH_PANEL => 'Графическая панель',
            self::FAX => 'Факс',
            self::SERVER => 'Сервер',
            self::NETWORK_BORDER => 'Межсетевой экран',
            self::TELEPHONE => 'Телефон',
            self::STORAGE => 'Накопитель данных',
            self::CAMERA => 'Камера',
            self::COMMUTATOR => 'Коммутатор',
            self::TV => 'Телевизор',
            self::SOUNDBAR => 'Саундбар',
            self::BATTERY => 'Аккумулятор',
            self::HEADSET => 'Гарнитура',
            self::OTHER => 'Другое'
        ];
    }
    public static function get($index){
        return self::type()[$index];
    }
    public static function indexElectronics($index){
        return array_search($index, self::type());
    }
}
