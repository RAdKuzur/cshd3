<?php

namespace App\Repositories;

use App\Helpers\Auth;
use App\Models\Log;
use App\Models\ThingAuditorium;
use Illuminate\Support\Facades\DB;

class ThingAuditoriumRepository
{
    public function get($id) : ThingAuditorium
    {
        return ThingAuditorium::find($id);
    }
    public function getAll(){
        return ThingAuditorium::all();
    }
    public function create($data)
    {
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => ThingAuditorium::class,
            'type' => Log::INSERT,
            'bindings' => json_encode($data),
            'extra_bindings' => null,
            'time' => now()
        ]);
        return DB::table('thing_auditoriums')->insert($data);
    }
    public function update($id, $data){
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => ThingAuditorium::class,
            'type' => Log::UPDATE,
            'bindings' => json_encode($data),
            'extra_bindings' => json_encode(['id' => $id]),
            'time' => now()
        ]);
        return DB::table('thing_auditoriums')->where('id', $id)->update($data);
    }
    public function delete($id){
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => ThingAuditorium::class,
            'type' => Log::DELETE,
            'bindings' => null,
            'extra_bindings' => json_encode(['id' => $id]),
            'time' => now()
        ]);
        return DB::table('thing_auditoriums')->where('id', $id)->delete();
    }

    public function deleteByListId(array $ids) {
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => ThingAuditorium::class,
            'type' => Log::DELETE,
            'bindings' => null,
            'extra_bindings' => json_encode(['ids' => $ids]),
            'time' => now()
        ]);
        return DB::table('thing_auditoriums')->whereIn('thing_id', $ids)->delete();

    }
}
