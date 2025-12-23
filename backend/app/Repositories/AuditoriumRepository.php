<?php

namespace App\Repositories;

use App\Helpers\Auth;
use App\Models\Auditorium;
use App\Models\Log;
use Illuminate\Support\Facades\DB;

class AuditoriumRepository
{
    public function getAll(){
        return Auditorium::all();
    }

    public function get($id) : Auditorium {
        return Auditorium::where(['id' => $id])->get();
    }
    public function create($data){
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => Auditorium::class,
            'type' => Log::INSERT,
            'bindings' => json_encode($data),
            'extra_bindings' => null,
            'time' => now()
        ]);
        return DB::table('auditoriums')->insert($data);
    }
    public function update($id, $data){
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => Auditorium::class,
            'type' => Log::UPDATE,
            'bindings' => json_encode($data),
            'extra_bindings' => json_encode(['id' => $id]),
            'time' => now()
        ]);
        return DB::table('auditoriums')->where('id', $id)->update($data);
    }
    public function delete($id){
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => Auditorium::class,
            'type' => Log::DELETE,
            'bindings' => null,
            'extra_bindings' => json_encode(['id' => $id]),
            'time' => now()
        ]);
        return DB::table('auditoriums')->where('id', $id)->delete();
    }
}
