<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\TokenRepository;
use App\Repositories\UserRepository;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    private TokenRepository $tokenRepository;
    private UserRepository $userRepository;
    public function __construct(
        TokenRepository $tokenRepository,
        UserRepository $userRepository
    )
    {
        $this->tokenRepository = $tokenRepository;
        $this->userRepository = $userRepository;
    }

    public function login($user)
    {
        $refreshToken = JWTAuth::claims([
            'type' => 'refresh',
            'user_id' => $user->id,
            'time' => now()
        ])->fromUser($user);
        $accessToken =  JWTAuth::claims([
            'type' => 'access',
            'user_id' => $user->id,
            'time' => now()
        ])->fromUser($user);
        $this->tokenRepository->create($refreshToken, $user);
        return [
            'refreshToken' => $refreshToken,
            'accessToken' => $accessToken,
        ];
    }
    public function logout($token){
        $this->tokenRepository->deleteByToken($token);
    }
    public function isAuth($accessToken, $refreshToken){
        if (is_null($refreshToken) && is_null($accessToken)) {
            //not authorizated
            return false;
        }
        else if(!is_null($refreshToken) && is_null($accessToken)){
            $data = JWTAuth::setToken($refreshToken)->getPayload();
            return count($this->tokenRepository->isValidToken($refreshToken, $data['user_id'])) > 0;
        }
        else if(!is_null($refreshToken) && !is_null($accessToken)){
            $data = JWTAuth::setToken($accessToken)->getPayload();
            return $data['user_id'] && count($this->tokenRepository->isValidToken($refreshToken, $data['user_id'])) > 0;
        }
        else {
            //not authorizated, but very strange situation
            return false;
        }
    }
    public function refresh($refreshToken)
    {
        $data = JWTAuth::setToken($refreshToken)->getPayload();
        $user = $this->userRepository->getById($data['user_id']);
        $this->tokenRepository->delete($refreshToken, $user);
        $refreshToken = JWTAuth::claims([
            'type' => 'refresh',
            'user_id' => $user->id,
            'time' => now()
        ])->fromUser($user);
        $accessToken = JWTAuth::claims([
            'type' => 'access',
            'user_id' => $user->id,
            'time' => now()
        ])->fromUser($user);
        $this->tokenRepository->create($refreshToken, $user);
        return [
            'refreshToken' => $refreshToken,
            'accessToken' => $accessToken,
        ];
    }
}
