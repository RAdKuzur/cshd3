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
    public function create($data) {
        return DB::table('branches')->insert($data);
    }
    public function update($id, $data) {
        return DB::table('branches')->where('id', $id)->update($data);
    }
    public function delete($id) {
        DB::table('branches')->where('id', $id)->delete();
    }
}
