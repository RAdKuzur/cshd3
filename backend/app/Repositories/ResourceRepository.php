<?php

namespace App\Repositories;

use App\Models\Resource;
use Illuminate\Support\Facades\DB;

class ResourceRepository
{
    public function getAll()
    {
        return Resource::all();
    }
    public function getById($id) : Resource {
        return Resource::find($id);
    }
    public function create($data) {
        return DB::table('resources')->insert($data);
    }
    public function update($id, $data) {
        return DB::table('resources')->where('id', $id)->update($data);
    }
    public function delete($id) {
        return DB::table('resources')->where('id', $id)->delete();
    }
}
