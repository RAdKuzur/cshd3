<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class TransferActThingRepository
{
    public function create($data){
        return DB::table("transfer_act_things")->insert($data);
    }
    public function update($id, $data){
        return DB::table("transfer_act_things")->where("id", $id)->update($data);
    }
    public function delete($id){
        return DB::table("transfer_act_things")->where("id", $id)->delete();
    }
}
