<?php

namespace App\Repositories;

use App\Helpers\Auth;
use App\Models\Log;
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
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => Position::class,
            'type' => Log::INSERT,
            'bindings' => json_encode($data),
            'extra_bindings' => null,
            'time' => now()
        ]);
        return DB::table('positions')->insert($data);
    }
    public function update($id,$data){
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => Position::class,
            'type' => Log::UPDATE,
            'bindings' => json_encode($data),
            'extra_bindings' => json_encode(['id' => $id]),
            'time' => now()
        ]);
        return DB::table('positions')->where('id' , $id)->update($data);
    }
    public function delete($id){
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => Position::class,
            'type' => Log::DELETE,
            'bindings' => null,
            'extra_bindings' => json_encode(['id' => $id]),
            'time' => now()
        ]);
        return DB::table('positions')->where('id' , $id)->delete();
    }
}
