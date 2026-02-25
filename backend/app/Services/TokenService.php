<?php

namespace App\Services;

use App\DTO\TokenDTO;
use App\Repositories\TokenRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;

class TokenService
{
    public TokenRepository $tokenRepository;
    public UserRepository $userRepository;
    public function __construct(
        TokenRepository $tokenRepository,
        UserRepository $userRepository
    )
    {
        $this->tokenRepository = $tokenRepository;
        $this->userRepository = $userRepository;
    }
    public function all() : array {
        $data = [];
        $tokens = $this->tokenRepository->getAllWithUsers();
        foreach ($tokens as $token) {
            $data[] = new TokenDTO(
                id: $token->id,
                refresh_token: $token->refresh_token,
                user_id: $token->user_id,
                expires_at: $token->expires_at,
                device_id: $token->device_id,
                is_revoked: $token->is_revoked,
                user_agent: $token->user_agent,
                ip_address: $token->ip_address,
                username: $token->user->username,
            );
        }

        return $data;
    }
    public function revoke($id) {
        DB::beginTransaction();
        try {
            $this->tokenRepository->update($id, [
                'is_revoked' => true
            ]);
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
        }
    }
    public function allUsername($username) : array {
        $data = [];
        $user = $this->userRepository->getByUsername($username);
        $tokens = $this->tokenRepository->getByUserId($user->id);
        foreach ($tokens as $token) {
            $data[] = new TokenDTO(
                id: $token->id,
                refresh_token: $token->refresh_token,
                user_id: $token->user_id,
                expires_at: $token->expires_at,
                device_id: $token->device_id,
                is_revoked: $token->is_revoked,
                user_agent: $token->user_agent,
                ip_address: $token->ip_address,
                username: $user->username
            );
        }
        return $data;
    }

    public function delete($id) {
        DB::beginTransaction();
        try {
            $this->tokenRepository->deleteById($id);
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
        }

    }
}
