<?php

namespace App\Repositories;

use App\Dictionaries\ThingTypeDictionary;
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
        return DB::table("things")->insert($data);
    }
    public function update($id, $data){
        return DB::table("things")->where('id', $id)->update($data);
    }
    public function delete($id){
        return DB::table("things")->where('id', $id)->delete();
    }
}
