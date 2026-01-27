<?php

namespace App\Helpers;

class UrlHelper
{
    public static function createUrlFromSearch($index, $id)
    {
        return env('FRONTEND_URL', 'http://localhost') . '/' . $index . '/view/' . $id;
    }
}
