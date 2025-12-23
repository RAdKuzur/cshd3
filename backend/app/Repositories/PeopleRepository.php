<?php

namespace App\Repositories;

use App\Helpers\Auth;
use App\Models\Log;
use App\Models\People;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PeopleRepository
{
    public function get($id) : People {
        return People::find($id);
    }
    public function getAll(){
        return People::all();
    }
    public function create($data){
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => People::class,
            'type' => Log::INSERT,
            'bindings' => json_encode($data),
            'extra_bindings' => null,
            'time' => now()
        ]);
        return DB::table('people')->insertGetId([
            'firstname' => $data['firstname'],
            'surname' => $data['surname'],
            'patronymic' => $data['patronymic'],
            'phone_number' => $data['phone_number'],
            'birthdate' => $data['birthdate'],
            'auditorium_id' => $data['auditorium_id'],
            'organization_id' => DB::table('organizations')->first()->id,
            'user_id' => $data['user_id'],
//            'about' => $data['bio'],
        ]);
    }
    public function updateByUserId($id,$data){
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => People::class,
            'type' => Log::UPDATE,
            'bindings' => json_encode($data),
            'extra_bindings' => json_encode(['user_id' => $id]),
            'time' => now()
        ]);

        return DB::table('people')->where('user_id',$id)->update([
            'firstname' => $data['firstname'],
            'surname' => $data['surname'],
            'patronymic' => $data['patronymic'],
            'phone_number' => $data['phone_number'],
            'birthdate' => $data['birthdate'],
            'auditorium_id' => $data['auditorium_id'],
            'organization_id' => DB::table('organizations')->first()->id,
            //'about' => $data['bio'],
        ]);
    }
    public function update($id,$data){
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => People::class,
            'type' => Log::UPDATE,
            'bindings' => json_encode($data),
            'extra_bindings' => json_encode(['id' => $id]),
            'time' => now()
        ]);
        return DB::table('people')->where('id',$id)->update([
            'firstname' => $data['firstname'],
            'surname' => $data['surname'],
            'patronymic' => $data['patronymic'],
            'phone_number' => $data['phone_number'],
            'birthdate' => $data['birthdate'],
            'auditorium_id' => $data['auditorium_id'],
            'organization_id' => DB::table('organizations')->first()->id,
            //'about' => $data['bio'],
        ]);
    }
    public function delete($id){
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => People::class,
            'type' => Log::DELETE,
            'bindings' => null,
            'extra_bindings' => json_encode(['id' => $id]),
            'time' => now()
        ]);

        return DB::table('people')->where('id',$id)->delete();
    }
    public function deleteByUserId($id){
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => People::class,
            'type' => Log::DELETE,
            'bindings' => null,
            'extra_bindings' => json_encode(['user_id' => $id]),
            'time' => now()
        ]);
        return DB::table('people')->where('user_id',$id)->delete();
    }
}
