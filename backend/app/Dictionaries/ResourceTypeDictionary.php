<?php

namespace App\Dictionaries;

class ResourceTypeDictionary implements BaseDictionary
{
    public const CARTRIDGE = 1;
    public const PAPER = 2;
    public static function type(){
        return [
            self::CARTRIDGE => 'Картридж',
            self::PAPER => 'Пачка бумаги'
        ];
    }
    public static function get($index){
        return self::type()[$index];
    }
    public static function index($index){
        return array_search($index, self::type());
    }
}
