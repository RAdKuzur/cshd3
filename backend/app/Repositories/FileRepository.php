<?php

namespace App\Repositories;

use App\Helpers\Auth;
use App\Helpers\LogHelper;
use App\Models\File;
use App\Models\Log;
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
        LogHelper::insert(File::class, $data);
        return DB::table('files')->insert($data);
    }
    public function update($id, $data){
        LogHelper::update(File::class, $data, ['id' => $id]);
        return DB::table('files')->where('id', $id)->update($data);
    }
    public function delete($id){
        LogHelper::delete(File::class, ['id' => $id]);
        return DB::table('files')->where('id', $id)->delete();
    }
    public function isPossibleToUpload($tableName) : bool {
        return DB::table($tableName)->exists();
    }

    public function getFiles($tableName, $rowId)
    {
        return File::where([
            'table_name' => $tableName,
            'row_id' => $rowId,
        ])->get();
    }
}
