<?php

namespace App\Repositories;

use App\Models\Auditorium;
use Illuminate\Support\Facades\DB;

class AuditoriumRepository
{
    public function getAll(){
        return Auditorium::all();
    }

    public function get($id){
        return Auditorium::where(['id' => $id])->first();
    }
    public function create($data){
        return DB::table('auditoriums')->insert($data);
    }
    public function update($id, $data){
        return DB::table('auditoriums')->where('id', $id)->update($data);
    }
    public function delete($id){
        return DB::table('auditoriums')->where('id', $id)->delete();
    }
}
