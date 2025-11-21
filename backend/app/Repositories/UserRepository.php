<?php

namespace App\Repositories;

use App\Models\User;

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
}
