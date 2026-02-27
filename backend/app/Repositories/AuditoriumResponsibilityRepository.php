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
    public function isPossibleToCreate($auditoriumId, $startDate) : bool
    {
        return !DB::table('auditorium_responsibilities')
                ->where('auditorium_id', $auditoriumId)
                ->where('start_date', '>', $startDate)
                ->exists();
    }

    public function updateOldOnCreate($auditoriumId, $endDate)
    {
        LogHelper::update(AuditoriumResponsibility::class, ['end_date' => $endDate], [
            'auditorium_id' => $auditoriumId,
            'end_date' => null
        ]);
        return DB::table('auditorium_responsibilities')
            ->where('auditorium_id', $auditoriumId)
            ->where('end_date', null)
            ->update(['end_date' => $endDate]);

    }
    public function updateOldOnUpdate($auditoriumId, $oldDate, $newDate)
    {
        LogHelper::update(AuditoriumResponsibility::class, ['end_date' => $newDate], [
            'auditorium_id' => $auditoriumId,
            'end_date' => $oldDate
        ]);
        return DB::table('auditorium_responsibilities')
            ->where('auditorium_id', $auditoriumId)
            ->where('end_date', $oldDate)
            ->update(['end_date' => $newDate]);

    }
    public function updateOldOnDelete($auditoriumId, $date)
    {
        LogHelper::update(AuditoriumResponsibility::class, ['end_date' => null], [
            'auditorium_id' => $auditoriumId,
            'end_date' => $date
        ]);
        return DB::table('auditorium_responsibilities')
            ->where('auditorium_id', $auditoriumId)
            ->where('end_date', $date)
            ->update(['end_date' => null]);

    }

    public function isPossibleToUpdate($id, $auditoriumId, $startDate) : bool
    {
        return DB::table('auditorium_responsibilities')
                ->where('id', $id)
                ->where('end_date', null)
                ->exists() && !DB::table('auditorium_responsibilities')
                ->whereNot('id', $id)
                ->where('auditorium_id', $auditoriumId)
                ->where('start_date', '>', $startDate)
                ->exists();
    }
    public function isPossibleToDelete($id) : bool {
        return DB::table('auditorium_responsibilities')
            ->where('id', $id)
            ->where('end_date', null)
            ->exists();
    }
}
