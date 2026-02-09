<?php

namespace App\Repositories;

use App\Helpers\Auth;
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
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => TechWork::class,
            'type' => Log::INSERT,
            'bindings' => json_encode($data),
            'extra_bindings' => null,
            'time' => now()
        ]);
        return DB::table('tech_works')->insert($data);
    }

    public function update($id, $data) {
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => TechWork::class,
            'type' => Log::UPDATE,
            'bindings' => json_encode($data),
            'extra_bindings' => json_encode(['id' => $id]),
            'time' => now()
        ]);
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
