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
            case 'transfer-acts':
                return 'things/transfer-acts';
            default:
                return null;
        }
    }
    public static function urlWithoutApi($url) : string
    {
        return str_replace('/api', '', $url);
    }
}
