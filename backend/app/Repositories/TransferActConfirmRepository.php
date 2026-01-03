<?php

namespace App\Repositories;

use App\Models\TransferActConfirm;
use Illuminate\Support\Facades\DB;

class TransferActConfirmRepository
{
    public function get($id) : TransferActConfirm
    {
        return TransferActConfirm::find($id);
    }
    public function getAll()
    {
        return TransferActConfirm::all();
    }
    public function create($data){
        return DB::table('transfer_act_confirm')->insert($data);
    }
    public function update($id, $data){
        return DB::table('transfer_act_confirm')->where('id', $id)->update($data);
    }
    public function delete($id){
        return DB::table('transfer_act_confirm')->where('id', $id)->delete();
    }
}
