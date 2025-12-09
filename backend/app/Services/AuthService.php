<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\PermissionRepository;
use App\Repositories\RuleRepository;
use App\Repositories\TokenRepository;
use App\Repositories\UserRepository;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    private TokenRepository $tokenRepository;
    private UserRepository $userRepository;
    private PermissionRepository $permissionRepository;
    private RuleRepository $ruleRepository;
    public function __construct(
        TokenRepository $tokenRepository,
        UserRepository $userRepository,
        PermissionRepository $permissionRepository,
        RuleRepository $ruleRepository
    )
    {
        $this->tokenRepository = $tokenRepository;
        $this->userRepository = $userRepository;
        $this->permissionRepository = $permissionRepository;
        $this->ruleRepository = $ruleRepository;
    }

    public function login($user)
    {
        $refreshToken = JWTAuth::setTTL((int)env('REFRESH_TOKEN_TIME'))->claims([
            'type' => 'refresh',
            'user_id' => $user->id,
            'time' => now(),
            'expires_at' => now()->addMinutes((int)env('REFRESH_TOKEN_TIME')),
        ])->fromUser($user);
        $accessToken = JWTAuth::setTTL((int)env('ACCESS_TOKEN_TIME'))->claims([
            'type' => 'access',
            'user_id' => $user->id,
            'time' => now()->addMinutes((int)env('ACCESS_TOKEN_TIME'))
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
            return false;
        }
        else if(!is_null($refreshToken) && is_null($accessToken)){
            $data = JWTAuth::setToken($refreshToken)->getPayload();
            return count($this->tokenRepository->isValidToken($refreshToken, $data['user_id'])) > 0;
        }
        else if(!is_null($refreshToken) && !is_null($accessToken)){
            $data = JWTAuth::setToken($refreshToken)->getPayload();
            return $data['user_id'] && count($this->tokenRepository->isValidToken($refreshToken, $data['user_id'])) > 0;
        }
        else {
            return false;
        }
    }
    public function refresh($refreshToken)
    {
        $data = JWTAuth::setToken($refreshToken)->getPayload();
        $user = $this->userRepository->getById($data['user_id']);
        $this->tokenRepository->delete($refreshToken, $user);
        $refreshToken = JWTAuth::setTTL((int)env('REFRESH_TOKEN_TIME'))->claims([
            'type' => 'refresh',
            'user_id' => $user->id,
        ])->fromUser($user);
        $accessToken = JWTAuth::setTTL((int)env('ACCESS_TOKEN_TIME'))->claims([
            'type' => 'access',
            'user_id' => $user->id,
            'time' => now()
        ])->fromUser($user);
        $this->tokenRepository->create($refreshToken, $user);
        return [
            'refreshToken' => $refreshToken,
            'accessToken' => $accessToken,
            'username' => $user->username,
            'fio' => $user->people->getFullFio(),
        ];
    }

    public function hasAccess($userId, $rule)
    {
        $ruleId = $this->ruleRepository->getByPath($rule) ? $this->ruleRepository->getByPath($rule)->id : 0;
        return $this->permissionRepository->hasAccess($userId, $ruleId);
    }
}
