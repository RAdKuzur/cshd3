<?php

namespace App\Repositories;

use App\Models\People;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PeopleRepository
{
    public function get($id){
        return People::find($id);
    }
    public function getAll(){
        return People::all();
    }
    public function create($data){
        //refactoring
        return DB::table('people')->insert([
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
        return DB::table('people')->where('id',$id)->delete();
    }
    public function deleteByUserId($id){
        return DB::table('people')->where('user_id',$id)->delete();
    }
}
