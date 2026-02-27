<?php

namespace App\Repositories;

use App\Helpers\Auth;
use App\Helpers\LogHelper;
use App\Models\Log;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function get($id)  : User {
        return User::where([
            'id' => $id
        ])->first();
    }
    public function getByEmail($email) : User {
        return User::where([
            'email' => $email
        ])->first();
    }
    public function getByUsername($username) : User
    {
        return User::where([
            'username' => $username
        ])->first();
    }
    public function getAll(){
        return User::all();
    }
    public function create($data)
    {
        LogHelper::insert(User::class, [
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role']
        ]);
        return DB::table('users')->insertGetId([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role']
        ]);
    }
    public function updateUser($id, $data){
        LogHelper::update(User::class, array_merge(
            [
                'username' => $data['username'],
                'email' => $data['email'],
            ],
            !empty($data['password']) ? ['password' => Hash::make($data['password'])] : []
        ), ['id' => $id]);
        return DB::table('users')->where('id', $id)->update(array_merge(
            [
                'username' => $data['username'],
                'email' => $data['email'],
                'role' => $data['role']
            ],
            !empty($data['password']) ? ['password' => Hash::make($data['password'])] : []
        ));
    }

    public function update($id, $data)
    {
        LogHelper::update(User::class, $data, ['id' => $id]);
        return DB::table('users')->where('id', $id)->update($data);
    }
    public function delete($id)
    {
        LogHelper::delete(User::class, ['id' => $id]);
        return DB::table('users')->where('id', $id)->delete();
    }

    public function isEmailExist($email) : bool
    {
        return DB::table('users')->where(['email' => $email])->exists();
    }
}
