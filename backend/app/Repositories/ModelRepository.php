<?php

namespace App\Repositories;

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
        return DB::table('models')->insert($data);
    }
    public function update($id, $data) {
        return DB::table('models')->where('id', $id)->update($data);
    }
    public function delete($id) {
        return DB::table('models')->where('id', $id)->delete();
    }
}
