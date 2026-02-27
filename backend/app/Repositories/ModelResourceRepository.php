<?php

namespace App\Repositories;

use App\Helpers\Auth;
use App\Helpers\LogHelper;
use App\Models\Log;
use App\Models\ModelResource;
use Illuminate\Support\Facades\DB;

class ModelResourceRepository
{
    public function getAll() {
        return ModelResource::all();
    }
    public function getById($id) : ModelResource {
        return ModelResource::find($id);
    }
    public function create($data) {
        LogHelper::insert(ModelResource::class, $data);
        return DB::table('model_resources')->insert($data);
    }
    public function update($id, $data) {
        LogHelper::update(ModelResource::class, $data, ['id' => $id]);
        return DB::table('model_resources')->where('id', $id)->update($data);
    }
    public function delete($id) {
        LogHelper::delete(ModelResource::class, ['id' => $id]);
        return DB::table('model_resources')->where('id', $id)->delete();
    }
}
