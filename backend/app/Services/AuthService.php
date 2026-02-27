<?php

namespace App\Services;

use App\DTO\ChangePasswordDTO;
use App\Events\PasswordChanged;
use App\Helpers\Auth;
use App\Helpers\LogHelper;
use App\Repositories\PermissionRepository;
use App\Repositories\RuleRepository;
use App\Repositories\TokenRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    private TokenRepository $tokenRepository;
    private PermissionRepository $permissionRepository;
    private RuleRepository $ruleRepository;
    private UserRepository $userRepository;
    public function __construct(
        TokenRepository $tokenRepository,
        PermissionRepository $permissionRepository,
        RuleRepository $ruleRepository,
        UserRepository $userRepository
    )
    {
        $this->tokenRepository = $tokenRepository;
        $this->permissionRepository = $permissionRepository;
        $this->ruleRepository = $ruleRepository;
        $this->userRepository = $userRepository;
    }

    public function login($user) : array
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
            LogHelper::error($e->getMessage(), $e->getTraceAsString());
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
            LogHelper::error($e->getMessage(), $e->getTraceAsString());
        }
    }
    public function isAuth($accessToken, $refreshToken) : bool {

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
    public function validateRefreshToken($refreshToken) : bool
    {
        if (is_null($refreshToken) || !JWTAuth::setToken($refreshToken)->check()) {
            return false;
        }
        $data = JWTAuth::setToken($refreshToken)->getPayload();
        return count($this->tokenRepository->isValidToken($refreshToken, $data['user_id'])) > 0;
    }
    public function refresh($refreshToken) : array
    {
        DB::beginTransaction();
        try {
            $user = Auth::userRefresh();
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
                'role' => $user->role,
                'icon_link' => $user->people->icon_link
            ];
        }
        catch (\Exception $e){
            DB::rollBack();
            LogHelper::error($e->getMessage(), $e->getTraceAsString());
            return [
                'refreshToken' => null,
                'accessToken' => null,
                'username' => null,
                'fio' => null,
                'role' => null,
                'icon_link' => null
            ];
        }

    }

    public function hasAccess($role, $rule) : bool
    {
        $ruleId = $this->ruleRepository->getByPath($rule) ? $this->ruleRepository->getByPath($rule)->id : 0;
        return $this->permissionRepository->hasAccess($role, $ruleId);
    }

    public function forgotPassword($email = null)
    {
        if($this->userRepository->isEmailExist($email)) {
            $user = $this->userRepository->getByEmail($email);
            PasswordChanged::dispatch($user->email, $user->username);
        }
    }
    public function changePassword(ChangePasswordDTO $changePasswordDTO)
    {
        DB::beginTransaction();
        try {
            if($this->userRepository->isEmailExist($changePasswordDTO->email)){
                $user = $this->userRepository->getByEmail($changePasswordDTO->email);
                $this->userRepository->update($user->id, [
                    'password' => Hash::make($changePasswordDTO->password)
                ]);
            }
            DB::commit();
        }
        catch (\Exception $e){
            DB::rollBack();
            LogHelper::error($e->getMessage(), $e->getTraceAsString());
        }
    }
}
