<?php

namespace App\Repositories;

use App\Helpers\Auth;
use App\Helpers\LogHelper;
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
        LogHelper::insert(HistoryResource::class, $data);
        return DB::table('history_resources')->insert($data);
    }
    public function update($id, $data) {
        LogHelper::update(HistoryResource::class, $data , ['id' => $id]);
        return DB::table('history_resources')->where('id', $id)->update($data);
    }
    public function delete($id) {
        LogHelper::delete(HistoryResource::class, ['id' => $id]);
        return DB::table('history_resources')->where('id', $id)->delete();
    }
}
