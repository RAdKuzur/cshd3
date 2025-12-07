<?php

namespace App\Repositories;

use App\Models\Position;
use Illuminate\Support\Facades\DB;

class PositionRepository
{
    public function get($id){
        return Position::find($id);
    }
    public function getAll(){
        return Position::all();
    }
    public function create($data){
        return DB::table('positions')->insert($data);
    }
    public function update($id,$data){
        return DB::table('positions')->where('id' , $id)->update($data);
    }
    public function delete($id){
        return DB::table('positions')->where('id' , $id)->delete();
    }
}
