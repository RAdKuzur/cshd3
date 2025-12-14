<?php

namespace App\Services;

use App\Helpers\Auth;
use App\Models\User;
use App\Repositories\PermissionRepository;
use App\Repositories\RuleRepository;
use App\Repositories\TokenRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    private TokenRepository $tokenRepository;
    private PermissionRepository $permissionRepository;
    private RuleRepository $ruleRepository;
    public function __construct(
        TokenRepository $tokenRepository,
        PermissionRepository $permissionRepository,
        RuleRepository $ruleRepository
    )
    {
        $this->tokenRepository = $tokenRepository;
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
        DB::beginTransaction();
        try {
            $this->tokenRepository->create($refreshToken, $user);
            DB::commit();
        }
        catch (\Exception $e){
            DB::rollBack();
        }
        return [
            'refreshToken' => $refreshToken,
            'accessToken' => $accessToken,
        ];
    }
    public function logout($token){
        DB::beginTransaction();
        try {
            $this->tokenRepository->deleteByToken($token);
            DB::commit();
        }
        catch (\Exception $e){
            DB::rollBack();
        }
    }
    public function isAuth($accessToken, $refreshToken){

        if (is_null($refreshToken) && is_null($accessToken)) {
            return false;
        }
        else if(!is_null($refreshToken) && is_null($accessToken) && JWTAuth::setToken($refreshToken)->check()){
            $data = JWTAuth::setToken($refreshToken)->getPayload();
            return count($this->tokenRepository->isValidToken($refreshToken, $data['user_id'])) > 0;
        }
        else if(!is_null($refreshToken) && !is_null($accessToken) && JWTAuth::setToken($refreshToken)->check()){
            $data = JWTAuth::setToken($refreshToken)->getPayload();
            return $data['user_id'] && count($this->tokenRepository->isValidToken($refreshToken, $data['user_id'])) > 0;
        }
        else {
            return false;
        }
    }
    public function refresh($refreshToken)
    {
        DB::beginTransaction();
        try {
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
            DB::commit();
            return [
                'refreshToken' => $refreshToken,
                'accessToken' => $accessToken,
                'username' => $user->username,
                'fio' => $user->people->getFullFio(),
            ];
        }
        catch (\Exception $e){
            DB::rollBack();
            return [
                'refreshToken' => null,
                'accessToken' => null,
                'username' => null,
                'fio' => null,
            ];
        }

    }

    public function hasAccess($userId, $rule)
    {
        $ruleId = $this->ruleRepository->getByPath($rule) ? $this->ruleRepository->getByPath($rule)->id : 0;
        return $this->permissionRepository->hasAccess($userId, $ruleId);
    }
}
