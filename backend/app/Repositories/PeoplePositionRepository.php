<?php

namespace App\Repositories;

use App\Models\PeoplePosition;

class PeoplePositionRepository
{
    public function getByBranch($branchId){
        return PeoplePosition::where('branch_id', $branchId)->get();
    }
    public function getByActiveBranchStuff($branchId){
        return PeoplePosition::where('branch_id', $branchId)->where('end_date', null)->get();
    }
}
