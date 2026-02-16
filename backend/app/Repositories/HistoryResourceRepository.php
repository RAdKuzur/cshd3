<?php

namespace App\Repositories;

use App\Helpers\Auth;
use App\Models\HistoryResource;
use App\Models\Log;
use Illuminate\Support\Facades\DB;

class HistoryResourceRepository
{
    public function getAll() {
        return HistoryResource::all();
    }
    public function getById($id) : HistoryResource|null {
        return HistoryResource::find($id);
    }

    public function create($data) {
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => HistoryResource::class,
            'type' => Log::INSERT,
            'bindings' => json_encode($data),
            'extra_bindings' => null,
            'time' => now()
        ]);
        return DB::table('history_resources')->insert($data);
    }
    public function update($id, $data) {
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => HistoryResource::class,
            'type' => Log::UPDATE,
            'bindings' => json_encode($data),
            'extra_bindings' => json_encode(['id' => $id]),
            'time' => now()
        ]);
        return DB::table('history_resources')->where('id', $id)->update($data);
    }
    public function delete($id) {
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => HistoryResource::class,
            'type' => Log::DELETE,
            'bindings' => null,
            'extra_bindings' => json_encode(['id' => $id]),
            'time' => now()
        ]);
        return DB::table('history_resources')->where('id', $id)->delete();
    }
}
