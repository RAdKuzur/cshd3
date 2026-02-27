<?php

namespace App\Repositories;

use App\Helpers\Auth;
use App\Helpers\LogHelper;
use App\Models\Log;
use App\Models\TransferActThing;
use Illuminate\Support\Facades\DB;

class TransferActThingRepository
{
    public function create($data){
        LogHelper::insert(TransferActThing::class, $data);
        return DB::table('transfer_act_things')->insert($data);
    }
    public function update($id, $data){
        LogHelper::update(TransferActThing::class, $data, ['id' => $id]);
        return DB::table('transfer_act_things')->where('id', $id)->update($data);
    }
    public function delete($id){
        LogHelper::delete(TransferActThing::class, ['id' => $id]);
        return DB::table('transfer_act_things')->where('id', $id)->delete();
    }
    public function deleteByTransferActIdAndThingId($transferActId, $thingId)
    {
        LogHelper::delete(TransferActThing::class, [
            'thing_id' => $thingId,
            'transfer_act_id' => $transferActId
        ]);
        return DB::table('transfer_act_things')
            ->where('transfer_act_id', $transferActId)
            ->where('thing_id', $thingId)
            ->delete();
    }
}
