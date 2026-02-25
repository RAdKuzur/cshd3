<?php

namespace App\Repositories;

use App\Helpers\Auth;
use App\Models\Log;
use App\Models\Token;
use Illuminate\Support\Facades\DB;

class TokenRepository
{
    public function getAll()
    {
        return Token::all();
    }
    public function getAllWithUsers()
    {
        return Token::with(['user'])->get();
    }
    public function get($id)
    {
        return Token::find($id);
    }
    public function getByUserId($id)
    {
        return Token::where(['user_id' => $id])->get();
    }
    public function create(string $token, $user)
    {
        $data = [
            'refresh_token' => $token,
            'user_id' => $user->id,
            'expires_at' => now()->addMinutes((int)(env('REFRESH_TOKEN_TIME'))),
            'is_revoked' => false,
            'user_agent' => request()->userAgent(),
            'ip_address' => request()->ip(),
        ];
        return DB::table('tokens')->insert($data);
    }
    public function update($id, $data) {
        return DB::table('tokens')->where('id', $id)->update($data);
    }
    public function isValidToken($token, $userId){
        return Token::where([
            'refresh_token' => $token,
            'user_id' => $userId,
            ['expires_at', '>', now()],
            'ip_address' => request()->ip(),
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
    public function deleteByUserId($userId){
        return DB::table('tokens')->where([
            'user_id' => $userId,
        ])->delete();
    }
    public function deleteByToken($token)
    {
        return DB::table('tokens')->where([
            'refresh_token' => $token,
        ])->delete();
    }
    public function getByRefreshToken($refreshToken) : Token {
        return Token::where('refresh_token', $refreshToken)->first();
    }
    public function deleteById($id)
    {
        return DB::table('tokens')->where('id', $id)->delete();
    }
}
