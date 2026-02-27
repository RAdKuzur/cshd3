<?php

namespace App\Repositories;

use App\Helpers\Auth;
use App\Helpers\LogHelper;
use App\Models\Log;
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
        LogHelper::insert(Resource::class, $data);
        return DB::table('resources')->insert($data);
    }
    public function update($id, $data) {
        LogHelper::update(Resource::class, $data, ['id' => $id]);
        return DB::table('resources')->where('id', $id)->update($data);
    }
    public function delete($id) {
        LogHelper::delete(Resource::class, ['id' => $id]);
        return DB::table('resources')->where('id', $id)->delete();
    }
}
