<?php

namespace App\Repositories;

use App\Helpers\Auth;
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
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => File::class,
            'type' => Log::INSERT,
            'bindings' => json_encode($data),
            'extra_bindings' => null,
            'time' => now()
        ]);
        return DB::table('files')->insert($data);
    }
    public function update($id, $data){
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => File::class,
            'type' => Log::UPDATE,
            'bindings' => json_encode($data),
            'extra_bindings' => json_encode(['id' => $id]),
            'time' => now()
        ]);
        return DB::table('files')->where('id', $id)->update($data);
    }
    public function delete($id){
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => File::class,
            'type' => Log::DELETE,
            'bindings' => null,
            'extra_bindings' => json_encode(['id' => $id]),
            'time' => now()
        ]);
        return DB::table('files')->where('id', $id)->delete();
    }
    public function isPossibleToUpload($tableName, $rowId) {
        return DB::table($tableName)->where([
            'id' => $rowId,
        ])->exists();
    }
}
