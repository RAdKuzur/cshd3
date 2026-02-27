<?php

namespace App\Repositories;

use App\Helpers\Auth;
use App\Helpers\LogHelper;
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
    public function getAllWithPeoplePositions()
    {
        return People::with(['peoplePositions'])->get();
    }
    public function create($data){
        LogHelper::insert(People::class, $data);
        return DB::table('people')->insertGetId([
            'firstname' => $data['firstname'],
            'surname' => $data['surname'],
            'patronymic' => $data['patronymic'],
            'phone_number' => $data['phone_number'],
            'birthdate' => $data['birthdate'],
            'auditorium_id' => $data['auditorium_id'],
            'organization_id' => DB::table('organizations')->first()->id,
            'user_id' => $data['user_id'],
            'is_active' => true,
            'about' => $data['about']
        ]);
    }
    public function updateByUserId($id, $data){
        LogHelper::update(People::class, $data, ['user_id' => $id]);
        return DB::table('people')->where('user_id',$id)->update([
            'firstname' => $data['firstname'],
            'surname' => $data['surname'],
            'patronymic' => $data['patronymic'],
            'phone_number' => $data['phone_number'],
            'birthdate' => $data['birthdate'],
            'auditorium_id' => $data['auditorium_id'],
            'organization_id' => DB::table('organizations')->first()->id,
            'about' => $data['about']
        ]);
    }
    public function update($id, $data){
        LogHelper::update(People::class, $data, ['id' => $id]);
        return DB::table('people')->where('id',$id)->update([
            'firstname' => $data['firstname'],
            'surname' => $data['surname'],
            'patronymic' => $data['patronymic'],
            'phone_number' => $data['phone_number'],
            'birthdate' => $data['birthdate'],
            'auditorium_id' => $data['auditorium_id'],
            'organization_id' => DB::table('organizations')->first()->id,
            'about' => $data['about']
        ]);
    }
    public function delete($id){
        LogHelper::delete(People::class, ['id' => $id]);
        return DB::table('people')->where('id',$id)->delete();
    }
    public function deleteByUserId($id){
        LogHelper::delete(People::class, ['user_id' => $id]);
        return DB::table('people')->where('user_id', $id)->delete();
    }
}
