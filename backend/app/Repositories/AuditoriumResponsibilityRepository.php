<?php

namespace App\Repositories;

use App\Helpers\Auth;
use App\Models\AuditoriumResponsibility;
use App\Models\Log;
use Illuminate\Support\Facades\DB;

class AuditoriumResponsibilityRepository
{
    public function getAll()
    {
        return AuditoriumResponsibility::all();
    }
    public function get($id) : AuditoriumResponsibility
    {
        return AuditoriumResponsibility::find($id);
    }
    public function create($data)
    {
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => AuditoriumResponsibility::class,
            'type' => Log::INSERT,
            'bindings' => json_encode($data),
            'extra_bindings' => null,
            'time' => now()
        ]);
        return DB::table('auditorium_responsibilities')->insert($data);
    }
    public function update($id, $data){
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => AuditoriumResponsibility::class,
            'type' => Log::UPDATE,
            'bindings' => json_encode($data),
            'extra_bindings' => json_encode(['id' => $id]),
            'time' => now()
        ]);
        return DB::table('auditorium_responsibilities')->where('id', $id)->update($data);
    }
    public function delete($id){
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => AuditoriumResponsibility::class,
            'type' => Log::DELETE,
            'bindings' => null,
            'extra_bindings' => json_encode(['id' => $id]),
            'time' => now()
        ]);
        return DB::table("auditorium_responsibilities")->where("id", $id)->delete();
    }
}
