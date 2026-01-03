<?php

namespace App\Repositories;

use App\Helpers\Auth;
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
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => TransferAct::class,
            'type' => Log::INSERT,
            'bindings' => json_encode($data),
            'extra_bindings' => null,
            'time' => now()
        ]);
        return DB::table('transfer_acts')->insertGetId(array_merge($data, ['confirmed' => 0]));
    }
    public function update($id, $data){
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => TransferAct::class,
            'type' => Log::UPDATE,
            'bindings' => json_encode($data),
            'extra_bindings' => json_encode(['id' => $id]),
            'time' => now()
        ]);
        return DB::table('transfer_acts')->where('id', $id)->update($data);
    }
    public function delete($id){
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => TransferAct::class,
            'type' => Log::DELETE,
            'bindings' => null,
            'extra_bindings' => json_encode(['id' => $id]),
            'time' => now()
        ]);
        return DB::table("transfer_acts")->where('id',$id)->delete();
    }
}
