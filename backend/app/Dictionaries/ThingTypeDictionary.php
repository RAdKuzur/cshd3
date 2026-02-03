<?php

namespace App\Dictionaries;

use function Symfony\Component\String\s;

class ThingTypeDictionary implements BaseDictionary
{
    public const PC = 1;
    public const MONITOR = 2;
    public const PRINTER_BW = 3;
    public const MFU_A4_BW = 4;
    public const IBP_ARM = 5;
    public const KMA = 6;
    public const SCANNER = 7;
    public const MONOPC = 8;
    public const PASSPORT_SCANNER = 9;
    public const CARD_PRINTER = 10;
    public const ARM = 11;
    public const STATION_VCN = 12;
    public const RADIO_SYSTEM = 13;
    public const GRAPH_PANEL = 14;
    public const FAX = 15;
    public const SERVER = 16;
    public const NETWORK_BORDER = 17;
    public const IP_TELEPHONE = 18;
    public const STORAGE = 19;
    public const WEB_CAMERA = 20;
    public const COMMUTATOR_8 = 21;
    public const TV = 22;
    public const SOUNDBAR = 23;
    public const BATTERY = 24;
    public const HEADSET = 25;
    public const OTHER = 26;
    public const LAPTOP = 27;
    public const PRINTER_COLOUR = 28;
    public const MFU_A4_COLOUR = 29;
    public const MFU_A3_BW = 30;
    public const MFU_A3_COLOUR = 31;
    public const DESKTOP_SCANNER = 32;
    public const STREAM_SCANNER = 33;
    public const BOOK_SCANNER = 34;
    public const SHD = 35;
    public const IBP_SERVER = 36;
    public const CHAIN_MAIL_NETWORK_SCREEN = 37;
    public const COMMUTATOR_24 = 38;
    public const COMMUTATOR_48 = 39;
    public const ROUTER = 40;
    public const CABINET_VCN = 41;
    public const STATION_AUDIO_PROTOCOL = 42;
    public const MOBILE_AUDIO_PROTOCOL = 43;
    public const PROFESSIONAL_AUDIO_RECORDER = 44;
    public const WITNESS_DEFENCE = 45;
    public const INFO_KIOSK = 46;
    public const INFO_PANEL = 47;
    public const STATION_AUDIO_VIDEO_PROTOCOL = 48;
    public const TABLE = 100;
    public const CHAIR = 101;
    public const SHELF = 102;
    public const SOFA = 103;

    public const ELECTRONICS = [
        self::PC,
        self::MONITOR,
        self::PRINTER_BW,
        self::MFU_A4_BW,
        self::IBP_ARM,
        self::KMA,
        self::SCANNER,
        self::MONOPC,
        self::PASSPORT_SCANNER,
        self::CARD_PRINTER,
        self::ARM,
        self::STATION_VCN,
        self::RADIO_SYSTEM,
        self::GRAPH_PANEL,
        self::FAX,
        self::SERVER,
        self::NETWORK_BORDER,
        self::IP_TELEPHONE,
        self::STORAGE,
        self::WEB_CAMERA,
        self::COMMUTATOR_8,
        self::TV,
        self::SOUNDBAR,
        self::BATTERY,
        self::HEADSET,
        self::OTHER,
        self::LAPTOP,
        self::PRINTER_COLOUR,
        self::MFU_A4_COLOUR,
        self::MFU_A3_BW,
        self::MFU_A3_COLOUR,
        self::DESKTOP_SCANNER,
        self::STREAM_SCANNER,
        self::BOOK_SCANNER,
        self::SHD,
        self::IBP_SERVER,
        self::CHAIN_MAIL_NETWORK_SCREEN,
        self::COMMUTATOR_24,
        self::COMMUTATOR_48,
        self::ROUTER,
        self::CABINET_VCN,
        self::STATION_AUDIO_PROTOCOL,
        self::MOBILE_AUDIO_PROTOCOL,
        self::PROFESSIONAL_AUDIO_RECORDER,
        self::WITNESS_DEFENCE,
        self::INFO_KIOSK,
        self::INFO_PANEL,
        self::STATION_AUDIO_VIDEO_PROTOCOL
    ];
    public const FURNITURE = [
        self::TABLE,
        self::CHAIR,
        self::SHELF,
        self::SOFA,
    ];
    public const SHORT_REPORT_TYPES = [
        self::ARM,
        self::IBP_ARM,
        self::LAPTOP,
        self::PRINTER_BW,
        self::PRINTER_COLOUR,
        self::MFU_A4_BW,
        self::MFU_A4_COLOUR,
        self::MFU_A3_BW,
        self::MFU_A3_COLOUR,
        self::DESKTOP_SCANNER,
        self::STREAM_SCANNER,
        self::BOOK_SCANNER,
        self::SHD,
        self::SERVER,
        self::IBP_SERVER,
        self::CHAIN_MAIL_NETWORK_SCREEN,
        self::COMMUTATOR_8,
        self::COMMUTATOR_24,
        self::COMMUTATOR_48,
        self::ROUTER,
        self::STATION_VCN,
        self::CABINET_VCN,
        self::STATION_AUDIO_PROTOCOL,
        self::MOBILE_AUDIO_PROTOCOL,
        self::PROFESSIONAL_AUDIO_RECORDER,
        self::WITNESS_DEFENCE,
        self::INFO_KIOSK,
        self::INFO_PANEL
    ];
    public const EXTENDED_REPORT_TYPES = [
        self::ARM,
        self::LAPTOP,
        self::PRINTER_BW,
        self::PRINTER_COLOUR,
        self::MFU_A4_BW,
        self::MFU_A4_COLOUR,
        self::MFU_A3_BW,
        self::MFU_A3_COLOUR,
        self::DESKTOP_SCANNER,
        self::STREAM_SCANNER,
        self::BOOK_SCANNER,
        self::SHD,
        self::SERVER,
        self::CHAIN_MAIL_NETWORK_SCREEN,
        self::COMMUTATOR_8,
        self::COMMUTATOR_24,
        self::COMMUTATOR_48,
        self::ROUTER,
        self::IP_TELEPHONE,
        self::STATION_VCN,
        self::STATION_VCN, //это ВКС + АЗ
        self::CABINET_VCN,
        self::WEB_CAMERA,
        self::STATION_AUDIO_PROTOCOL,
        self::MOBILE_AUDIO_PROTOCOL,
        self::STATION_AUDIO_VIDEO_PROTOCOL,
        self::PROFESSIONAL_AUDIO_RECORDER,
        self::WITNESS_DEFENCE,
        self::INFO_KIOSK,
        self::INFO_PANEL,
    ];
    public static function type(){
        return [
            self::PC => 'Системный блок',
            self::MONITOR => 'Монитор',
            self::PRINTER_BW => 'Принтер ч/б',
            self::MFU_A4_BW => 'МФУ А4 ч/б',
            self::IBP_ARM => 'ИБП для АРМ',
            self::KMA => 'КМА',
            self::SCANNER => 'Сканер',
            self::MONOPC => 'Моноблок',
            self::PASSPORT_SCANNER => 'Сканер паспортов',
            self::CARD_PRINTER => 'Принтер для карточек',
            self::ARM => 'АРМ',
            self::STATION_VCN => 'Стационарный комлект ВКС',
            self::RADIO_SYSTEM => 'Радиосистема',
            self::GRAPH_PANEL => 'Графическая панель',
            self::FAX => 'Факс',
            self::SERVER => 'Сервер',
            self::NETWORK_BORDER => 'Межсетевой экран',
            self::IP_TELEPHONE => 'IP-Телефон',
            self::STORAGE => 'Накопитель данных',
            self::WEB_CAMERA => 'Веб-камера',
            self::COMMUTATOR_8 => 'Коммутатор 8 портов',
            self::TV => 'Телевизор',
            self::SOUNDBAR => 'Саундбар',
            self::BATTERY => 'Аккумулятор',
            self::HEADSET => 'Гарнитура',
            self::OTHER => 'Другое',
            self::LAPTOP => 'Ноутбук',
            self::PRINTER_COLOUR => 'Принтер цветной',
            self::MFU_A4_COLOUR => 'МФУ А4 цветной',
            self::MFU_A3_BW => 'МФУ (КМА) А3 ч/б',
            self::MFU_A3_COLOUR => 'МФУ (КМА) А3 цветной',
            self::DESKTOP_SCANNER => 'Планшетный сканер',
            self::STREAM_SCANNER => 'Протяжный (поточный) сканер',
            self::BOOK_SCANNER => 'Планетарный (книжный) сканер',
            self::SHD => 'Система хранения данных (СХД)',
            self::IBP_SERVER => 'ИБП для сервера',
            self::CHAIN_MAIL_NETWORK_SCREEN => 'Межсетевой экран «Кольчуга»',
            self::COMMUTATOR_24 => 'Коммутатор 9-24 порта',
            self::COMMUTATOR_48 => 'Коммутатор от 25 портов и более',
            self::ROUTER => 'Маршрутизатор',
            self::CABINET_VCN => 'Кабинетный комплект ВКС',
            self::STATION_AUDIO_PROTOCOL => 'Стационарный комплект аудиопротоколирования',
            self::MOBILE_AUDIO_PROTOCOL => 'Мобильный комплект аудиопротоколирования',
            self::PROFESSIONAL_AUDIO_RECORDER => 'Профессиональный аудиорекордер',
            self::WITNESS_DEFENCE => 'Комплекс обеспечения защиты свидетеля',
            self::INFO_KIOSK => 'Информационный киоск',
            self::INFO_PANEL => 'Информационная ЖК-панель (информационное табло)',
            self::TABLE => 'Стол',
            self::CHAIR => 'Стул/кресло',
            self::SHELF => 'Шкаф',
            self::SOFA => 'Диван',
            self::STATION_AUDIO_VIDEO_PROTOCOL => 'Стационарный комплект аудиовидеопротоколирования'
        ];
    }
    public static function get($index){
        return self::type()[$index];
    }
    public static function index($index){
        return array_search($index, self::type());
    }
}
