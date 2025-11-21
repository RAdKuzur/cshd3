<?php

namespace App\Repositories;

use App\Models\Token;

class TokenRepository
{
    public function create(string $token, $user)
    {
        return Token::create([
            'refresh_token' => $token,
            'user_id' => $user->id,
            'expires_at' => now()->addMinutes((int)(env('REFRESH_TOKEN_TIME'))),
            'is_revoked' => false,
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'ip_address' => $_SERVER['REMOTE_ADDR']
        ]);
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
        return Token::where([
            'refresh_token' => $token,
            'user_id' => $user->id,
        ])->delete();
    }

}
