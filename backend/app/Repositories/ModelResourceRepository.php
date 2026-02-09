<?php

namespace App\Repositories;

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
        return DB::table('model_resources')->insert($data);
    }
    public function update($id, $data) {
        return DB::table('model_resources')->where('id', $id)->update($data);
    }
    public function delete($id) {
        return DB::table('model_resources')->where('id', $id)->delete();
    }
}
