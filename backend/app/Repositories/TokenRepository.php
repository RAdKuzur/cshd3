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
            'expires_at' => now()->addMinutes(10),
            'is_revoked' => false,
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'ip_address' => $_SERVER['REMOTE_ADDR']
        ]);
    }
    public function getToken(){

    }
}
