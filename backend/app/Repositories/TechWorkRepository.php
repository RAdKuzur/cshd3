<?php

namespace App\Repositories;

use App\Models\TechWork;
use Illuminate\Support\Facades\DB;

class TechWorkRepository
{
    public function getAll() {
        return TechWork::all();
    }
    public function getById($id) {
        return TechWork::find($id);
    }
    public function create($data) {
        return DB::table('tech_works')->insert($data);
    }

    public function update($id, $data) {
        return DB::table('tech_works')->where('id', $id)->update($data);
    }
    public function isTechWork() : bool {
        return DB::table('tech_works')
            ->where('status', TechWork::ACTIVE)
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            ->exists();
    }
}
