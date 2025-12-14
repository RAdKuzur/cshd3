<?php

namespace App\Repositories;

use App\Helpers\Auth;
use App\Models\Log;
use App\Models\Token;
use Illuminate\Support\Facades\DB;

class TokenRepository
{
    public function create(string $token, $user)
    {
        $data = [
            'refresh_token' => $token,
            'user_id' => $user->id,
            'expires_at' => now()->addMinutes((int)(env('REFRESH_TOKEN_TIME'))),
            'is_revoked' => false,
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'ip_address' => $_SERVER['REMOTE_ADDR']
        ];
        return DB::table('tokens')->insert($data);
    }
    public function isValidToken($token, $userId){
        return Token::where([
            'refresh_token' => $token,
            'user_id' => $userId,
            ['expires_at', '>', now()],
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'is_revoked' => false
            //прочие фильтры
        ])->get();
    }
    public function delete($token, $user){
        return DB::table('tokens')->where([
            'refresh_token' => $token,
            'user_id' => $user->id,
        ])->delete();
    }
    public function deleteByToken($token)
    {
        return DB::table('tokens')->where([
            'refresh_token' => $token,
        ])->delete();
    }
}
