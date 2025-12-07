<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function getById($id){
        return User::where([
            'id' => $id
        ])->first();
    }
    public function getByEmail($email){
        return User::where([
            'email' => $email
        ])->first();
    }
    public function getByUsername($username){
        return User::where([
            'username' => $username
        ])->first();
    }
    public function getAll(){
        return User::all();
    }
    public function create($data)
    {
        return DB::table("users")->insert([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
    public function update($id, $data){
        return DB::table("users")->where("id", $id)->update([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
    public function delete($id)
    {
        return DB::table('users')->where('id', $id)->delete();
    }
}
