<?php

namespace App\Repositories;

use App\Helpers\Auth;
use App\Models\Log;
use App\Models\TransferActThing;
use Illuminate\Support\Facades\DB;

class TransferActThingRepository
{
    public function create($data){
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => TransferActThing::class,
            'type' => Log::INSERT,
            'bindings' => json_encode($data),
            'extra_bindings' => null,
            'time' => now()
        ]);
        return DB::table('transfer_act_things')->insert($data);
    }
    public function update($id, $data){
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => TransferActThing::class,
            'type' => Log::UPDATE,
            'bindings' => json_encode($data),
            'extra_bindings' => json_encode(['id' => $id]),
            'time' => now()
        ]);
        return DB::table('transfer_act_things')->where('id', $id)->update($data);
    }
    public function delete($id){
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => TransferActThing::class,
            'type' => Log::DELETE,
            'bindings' => null,
            'extra_bindings' => json_encode(['id' => $id]),
            'time' => now()
        ]);
        return DB::table('transfer_act_things')->where('id', $id)->delete();
    }
    public function deleteByTransferActIdAndThingId($transferActId, $thingId)
    {
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => TransferActThing::class,
            'type' => Log::DELETE,
            'bindings' => null,
            'extra_bindings' => json_encode([
                'thing_id' => $thingId,
                'transfer_act_id' => $transferActId
            ]),
            'time' => now()
        ]);
        return DB::table('transfer_act_things')
            ->where('transfer_act_id', $transferActId)
            ->where('thing_id', $thingId)
            ->delete();
    }
}
