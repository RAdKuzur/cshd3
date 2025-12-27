<?php

namespace App\Repositories;

use App\Models\File;
use Illuminate\Support\Facades\DB;

class FileRepository
{
    public function getAll() {
        return File::all();
    }
    public function get($id) : File {
        return File::find($id);
    }
    public function create($data){
        return DB::table("files")->insert($data);
    }
    public function update($id, $data){
        return DB::table("files")->where("id", $id)->update($data);
    }
    public function delete($id){
        return DB::table("files")->where("id", $id)->delete();
    }
}
