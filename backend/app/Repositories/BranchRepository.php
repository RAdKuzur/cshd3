<?php

namespace App\Repositories;

use App\Models\Branch;
use Illuminate\Support\Facades\DB;

class BranchRepository
{
    public function get($id) : Branch {
        return Branch::find($id);
    }
    public function getAll(){
        return Branch::all();
    }
}
