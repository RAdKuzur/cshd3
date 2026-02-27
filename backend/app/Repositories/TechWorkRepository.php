<?php

namespace App\Repositories;

use App\Helpers\Auth;
use App\Helpers\LogHelper;
use App\Models\Log;
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
        LogHelper::insert(TechWork::class, $data);
        return DB::table('tech_works')->insert($data);
    }

    public function update($id, $data) {
        LogHelper::update(TechWork::class, $data, ['id' => $id]);
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
