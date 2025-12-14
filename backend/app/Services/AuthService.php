<?php

namespace App\Services;

use App\Helpers\Auth;
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
        $accessToken = JWTAuth::customClaims([
            'type' => 'access',
            'user_id' => $user->id,
            'exp' => now()->addMinutes((int)env('ACCESS_TOKEN_TIME'))->timestamp])
            ->fromUser($user);
        $refreshToken = JWTAuth::customClaims([
            'type' => 'refresh',
            'user_id' => $user->id,
            'exp' => now()->addMinutes((int)env('REFRESH_TOKEN_TIME'))->timestamp
        ])
        ->fromUser($user);
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
        $user = Auth::user();
        $this->tokenRepository->delete($refreshToken, $user);
        $accessToken = JWTAuth::customClaims([
            'type' => 'access',
            'user_id' => $user->id,
            'exp' => now()->addMinutes((int)env('ACCESS_TOKEN_TIME'))->timestamp])
            ->fromUser($user);
        $refreshToken = JWTAuth::customClaims([
            'type' => 'refresh',
            'user_id' => $user->id,
            'exp' => now()->addMinutes((int)env('REFRESH_TOKEN_TIME'))->timestamp
        ])
            ->fromUser($user);
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
