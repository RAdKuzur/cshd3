<?php

namespace App\Repositories;

use App\Helpers\Auth;
use App\Helpers\LogHelper;
use App\Models\Log;
use App\Models\Model;
use Illuminate\Support\Facades\DB;

class ModelRepository
{
    public function getAll() {
        return Model::all();
    }
    public function getById($id) : Model
    {
        return Model::find($id);
    }
    public function create($data) {
        LogHelper::insert(Model::class, $data);
        return DB::table('models')->insert($data);
    }
    public function update($id, $data) {
        LogHelper::update(Model::class, $data, ['id' => $id]);
        return DB::table('models')->where('id', $id)->update($data);
    }
    public function delete($id) {
        LogHelper::delete(Model::class, ['id' => $id]);
        return DB::table('models')->where('id', $id)->delete();
    }
}
