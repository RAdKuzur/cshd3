<?php

namespace App\Repositories;

use App\Helpers\Auth;
use App\Models\Log;
use App\Models\TransferActConfirm;
use Illuminate\Support\Facades\DB;

class TransferActConfirmRepository
{
    public function get($id) : TransferActConfirm
    {
        return TransferActConfirm::find($id);
    }
    public function getByTransferActIdAndPeoplePositionId($transferActId, $peoplePositionId) : TransferActConfirm
    {
        return TransferActConfirm::where('transfer_act_id', $transferActId)->where('people_position_id', $peoplePositionId)->first();
    }
    public function getByTransferActId($transferActId)
    {
        return TransferActConfirm::where('transfer_act_id', $transferActId)->all();
    }
    public function getAll()
    {
        return TransferActConfirm::all();
    }
    public function create($data){
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => TransferActConfirm::class,
            'type' => Log::INSERT,
            'bindings' => json_encode($data),
            'extra_bindings' => null,
            'time' => now()
        ]);
        return DB::table('transfer_act_confirm')->insert($data);
    }
    public function update($id, $data){
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => TransferActConfirm::class,
            'type' => Log::UPDATE,
            'bindings' => json_encode($data),
            'extra_bindings' => json_encode(['id' => $id]),
            'time' => now()
        ]);
        return DB::table('transfer_act_confirm')->where('id', $id)->update($data);
    }
    public function delete($id){
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => TransferActConfirm::class,
            'type' => Log::DELETE,
            'bindings' => null,
            'extra_bindings' => json_encode(['id' => $id]),
            'time' => now()
        ]);
        return DB::table('transfer_act_confirm')->where('id', $id)->delete();
    }
}
