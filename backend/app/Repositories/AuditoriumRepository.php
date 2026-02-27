<?php

namespace App\Repositories;

use App\Helpers\Auth;
use App\Helpers\LogHelper;
use App\Models\Auditorium;
use App\Models\Log;
use Illuminate\Support\Facades\DB;

class AuditoriumRepository
{
    public function getAll(){
        return Auditorium::all();
    }
    public function getWithThingsAll(){
        return Auditorium::with([
            'branch.organization',
            'thingAuditoriums.thing'
        ])->get();
    }
    public function get($id) : Auditorium {
        return Auditorium::find($id);
    }
    public function getWithThingsById($id)
    {
        return Auditorium::with([
            'branch.organization',
            'thingAuditoriums.thing'
        ])->find($id);
    }
    public function create($data){
        LogHelper::insert(Auditorium::class, $data);
        return DB::table('auditoriums')->insert($data);
    }
    public function update($id, $data){
        LogHelper::update(Auditorium::class, $data, ['id' => $id]);
        return DB::table('auditoriums')->where('id', $id)->update($data);
    }
    public function delete($id){
        LogHelper::delete(Auditorium::class, ['id' => $id]);
        return DB::table('auditoriums')->where('id', $id)->delete();
    }
}
