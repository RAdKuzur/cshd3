<?php

namespace App\Repositories;

use App\Helpers\Auth;
use App\Helpers\LogHelper;
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
        LogHelper::insert(Branch::class, $data);
        return DB::table('branches')->insert($data);
    }
    public function update($id, $data) {
        LogHelper::update(Branch::class, $data, ['id' => $id]);
        return DB::table('branches')->where('id', $id)->update($data);
    }
    public function delete($id) {
        LogHelper::delete(Branch::class, ['id' => $id]);
        DB::table('branches')->where('id', $id)->delete();
    }
}
