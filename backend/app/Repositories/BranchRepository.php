<?php

namespace App\Repositories;

use App\Helpers\Auth;
use App\Models\Branch;
use App\Models\Log;
use Illuminate\Support\Facades\DB;

class BranchRepository
{
    public function get($id) : Branch {
        return Branch::find($id);
    }
    public function getAll(){
        return Branch::all();
    }
    public function create($data) {
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => Branch::class,
            'type' => Log::INSERT,
            'bindings' => json_encode($data),
            'extra_bindings' => null,
            'time' => now()
        ]);
        return DB::table('branches')->insert($data);
    }
    public function update($id, $data) {
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => Branch::class,
            'type' => Log::UPDATE,
            'bindings' => json_encode($data),
            'extra_bindings' => json_encode(['id' => $id]),
            'time' => now()
        ]);
        return DB::table('branches')->where('id', $id)->update($data);
    }
    public function delete($id) {
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => Branch::class,
            'type' => Log::DELETE,
            'bindings' => null,
            'extra_bindings' => json_encode(['id' => $id]),
            'time' => now()
        ]);
        DB::table('branches')->where('id', $id)->delete();
    }
}
