<?php

namespace App\Repositories;

use App\Helpers\Auth;
use App\Helpers\LogHelper;
use App\Models\Log;
use App\Models\TransferAct;
use Illuminate\Support\Facades\DB;

class TransferActRepository
{
    public function getAll()
    {
        return TransferAct::all();
    }
    public function get($id) : TransferAct {
        return TransferAct::find($id);
    }
    public function create($data)
    {
        LogHelper::insert(TransferAct::class, $data);
        return DB::table('transfer_acts')->insertGetId($data);
    }
    public function update($id, $data){
        LogHelper::update(TransferAct::class, $data, ['id' => $id]);
        return DB::table('transfer_acts')->where('id', $id)->update($data);
    }
    public function delete($id){
        LogHelper::delete(TransferAct::class, ['id' => $id]);
        return DB::table('transfer_acts')->where('id', $id)->delete();
    }
}
