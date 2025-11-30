<?php

namespace App\Repositories;

use App\Models\Branch;
use Illuminate\Support\Facades\DB;

class BranchRepository
{
    public function get($id){
        return DB::table('branches')->where(['id' => $id])->get();
    }
    public function getAll(){
        return DB::table('branches')->get();
    }
}
