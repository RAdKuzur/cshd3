<?php

namespace App\Helpers;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class Auth
{
    public static function user() : User|int {
        $accessToken = request()->cookie('access_token');
        $refreshToken = request()->cookie('refresh_token');
        if($refreshToken && JWTAuth::setToken($refreshToken)->check()){
            $payload = JWTAuth::setToken($refreshToken)->getPayload();
            $user = User::find($payload['user_id']);
            return $user;
        }
        return 0;
    }
    public static function check() : bool {
        $accessToken = request()->cookie('access_token');
        $refreshToken = request()->cookie('refresh_token');
        return $refreshToken && JWTAuth::setToken($refreshToken)->check();
    }
}
