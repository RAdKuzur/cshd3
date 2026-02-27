<?php

namespace App\Repositories;

use App\Helpers\Auth;
use App\Helpers\LogHelper;
use App\Models\Log;
use App\Models\Position;
use Illuminate\Support\Facades\DB;

class PositionRepository
{
    public function get($id) : Position {
        return Position::find($id);
    }
    public function getAll(){
        return Position::all();
    }
    public function create($data){
        LogHelper::insert(Position::class, $data);
        return DB::table('positions')->insert($data);
    }
    public function update($id, $data){
        LogHelper::update(Position::class, $data, ['id' => $id]);
        return DB::table('positions')->where('id' , $id)->update($data);
    }
    public function delete($id){
        LogHelper::delete(Position::class, ['id' => $id]);
        return DB::table('positions')->where('id' , $id)->delete();
    }
}
