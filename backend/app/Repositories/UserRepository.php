<?php

namespace App\Repositories;

use App\Helpers\Auth;
use App\Models\Log;
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
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => User::class,
            'type' => Log::INSERT,
            'bindings' => json_encode([
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]),
            'extra_bindings' => null,
            'time' => now()
        ]);
        return DB::table("users")->insertGetId([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
    public function update($id, $data){
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => User::class,
            'type' => Log::UPDATE,
            'bindings' => json_encode(array_merge(
                [
                    'username' => $data['username'],
                    'email' => $data['email'],
                ],
                !empty($data['password']) ? ['password' => Hash::make($data['password'])] : []
            )),
            'extra_bindings' => json_encode(['id' => $id]),
            'time' => now()
        ]);
        return DB::table("users")->where('id', $id)->update(array_merge(
            [
                'username' => $data['username'],
                'email' => $data['email'],
            ],
            !empty($data['password']) ? ['password' => Hash::make($data['password'])] : []
        ));
    }
    public function delete($id)
    {
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => User::class,
            'type' => Log::DELETE,
            'bindings' => null,
            'extra_bindings' => json_encode(['id' => $id]),
            'time' => now()
        ]);
        return DB::table('users')->where('id', $id)->delete();
    }
}
