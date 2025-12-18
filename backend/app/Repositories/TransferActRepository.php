<?php

namespace App\Repositories;

use App\Models\TransferAct;
use Illuminate\Support\Facades\DB;

class TransferActRepository
{
    public function getAll()
    {
        return TransferAct::all();
    }
    public function get($id){
        return TransferAct::find($id);
    }
    public function create($data)
    {
        return DB::table('transfer_acts')->insertGetId(array_merge($data, ['confirmed' => 0, 'time' => now()]));
    }
    public function update( $id, $data ){
        return DB::table('transfer_acts')->where('id', $id)->update($data);
    }
    public function delete($id){
        return DB::table("transfer_acts")->where("id",$id)->delete();
    }
}
