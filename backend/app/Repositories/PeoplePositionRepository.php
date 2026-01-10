<?php

namespace App\Repositories;

use App\Helpers\Auth;
use App\Models\Log;
use App\Models\PeoplePosition;
use Illuminate\Support\Facades\DB;

class PeoplePositionRepository
{
    public function getByBranch($branchId){
        return PeoplePosition::where('branch_id', $branchId)->get();
    }
    public function getByActiveBranchStuff($branchId){
        return PeoplePosition::where('branch_id', $branchId)->where('end_date', null)->get();
    }
    public function delete($id){
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => PeoplePosition::class,
            'type' => Log::DELETE,
            'bindings' => null,
            'extra_bindings' => json_encode(['id' => $id]),
            'time' => now()
        ]);
        return DB::table('people_positions')->where('id', $id)->delete();
    }
}
