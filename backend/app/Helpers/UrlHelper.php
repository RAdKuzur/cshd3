<?php

namespace App\Helpers;

class UrlHelper
{
    public static function createUrlFromSearch($index, $id)
    {
        return env('FRONTEND_URL', 'http://localhost') . '/' . self::map($index) . '/view/' . $id;
    }

    public static function map($index)
    {
        switch ($index) {
            case 'things':
                return 'things';
            case 'network-things':
                return 'things/network';
            default:
                return null;
        }
    }
}
