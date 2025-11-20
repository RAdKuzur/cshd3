<?php

namespace App\Services;

use App\Repositories\TokenRepository;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    private TokenRepository $tokenRepository;
    public function __construct(
        TokenRepository $tokenRepository
    )
    {
        $this->tokenRepository = $tokenRepository;
    }

    public function login($user)
    {
        $refreshToken =  bin2hex(random_bytes(64));;
        $accessToken = JWTAuth::fromUser($user);
        $this->tokenRepository->create($refreshToken, $user);
        return [
            'refreshToken' => $refreshToken,
            'accessToken' => $accessToken,
        ];
    }
    public function refresh(){

    }
}
