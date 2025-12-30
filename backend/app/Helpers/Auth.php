<?php

namespace App\Helpers;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class Auth
{
    public static function user() : User|int {
        $accessToken = request()->cookie('access_token');
        if($accessToken && JWTAuth::setToken($accessToken)->check()){
            $payload = JWTAuth::setToken($accessToken)->getPayload();
            $user = User::find($payload['user_id']);
            return $user;
        }
        return 0;
    }
    public static function check() : bool {
        $accessToken = request()->cookie('access_token');
        return $accessToken && JWTAuth::setToken($accessToken)->check();
    }
    public static function id() : int|null {
        $accessToken = request()->cookie('access_token');
        if($accessToken && JWTAuth::setToken($accessToken)->check()){
            $payload = JWTAuth::setToken($accessToken)->getPayload();
            $user = User::find($payload['user_id']);
            return $user->id;
        }
        return null;
    }
}
