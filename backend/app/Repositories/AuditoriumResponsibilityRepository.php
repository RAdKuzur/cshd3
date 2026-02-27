<?php

namespace App\Repositories;

use App\Helpers\Auth;
use App\Helpers\LogHelper;
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
        LogHelper::insert(AuditoriumResponsibility::class, $data);
        return DB::table('auditorium_responsibilities')->insert($data);
    }
    public function update($id, $data){
        LogHelper::update(AuditoriumResponsibility::class, $data, ['id' => $id]);
        return DB::table('auditorium_responsibilities')->where('id', $id)->update($data);
    }
    public function delete($id){
        LogHelper::delete(AuditoriumResponsibility::class, ['id' => $id]);
        return DB::table("auditorium_responsibilities")->where("id", $id)->delete();
    }
}
