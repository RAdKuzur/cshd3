<?php

namespace App\Repositories;

use App\Dictionaries\ThingTypeDictionary;
use App\Helpers\Auth;
use App\Models\Log;
use App\Models\Thing;
use Illuminate\Support\Facades\DB;

class ThingRepository
{
    public function get($id)
    {
        return Thing::where('id', $id)->first();
    }
    public function getAll(){
        return Thing::all();
    }
    public function getElectronics()
    {
        return Thing::whereIn('thing_type_id', ThingTypeDictionary::ELECTRONICS)->get();
    }
    public function create($data)
    {
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => Thing::class,
            'type' => Log::INSERT,
            'bindings' => json_encode($data),
            'extra_bindings' => null,
            'time' => now()
        ]);
        return DB::table("things")->insert($data);
    }
    public function update($id, $data){
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => Thing::class,
            'type' => Log::UPDATE,
            'bindings' => json_encode($data),
            'extra_bindings' => json_encode(['id' => $id]),
            'time' => now()
        ]);
        return DB::table("things")->where('id', $id)->update($data);
    }
    public function delete($id){
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => Thing::class,
            'type' => Log::DELETE,
            'bindings' => null,
            'extra_bindings' => json_encode(['id' => $id]),
            'time' => now()
        ]);
        return DB::table("things")->where('id', $id)->delete();
    }
}
