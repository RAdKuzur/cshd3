<?php

namespace App\Repositories;

use App\Helpers\Auth;
use App\Helpers\LogHelper;
use App\Models\Log;
use App\Models\ThingAuditorium;
use Illuminate\Support\Facades\DB;

class ThingAuditoriumRepository
{
    public function get($id) : ThingAuditorium
    {
        return ThingAuditorium::find($id);
    }
    public function getAll(){
        return ThingAuditorium::all();
    }
    public function create($data)
    {
        LogHelper::insert(ThingAuditorium::class, $data);
        return DB::table('thing_auditoriums')->insert($data);
    }
    public function update($id, $data){
        LogHelper::update(ThingAuditorium::class, $data, ['id' => $id]);
        return DB::table('thing_auditoriums')->where('id', $id)->update($data);
    }
    public function delete($id){
        LogHelper::delete(ThingAuditorium::class, ['id' => $id]);
        return DB::table('thing_auditoriums')->where('id', $id)->delete();
    }

    public function deleteByListId(array $ids) {
        LogHelper::delete(ThingAuditorium::class, ['id' => $ids]);
        return DB::table('thing_auditoriums')->whereIn('thing_id', $ids)->delete();
    }

    public function isPossibleToCreate($thingId, $startDate) : bool
    {
        return !DB::table('thing_auditoriums')
            ->where('thing_id', $thingId)
            ->where('start_date', '>', $startDate)
            ->exists();
    }

    public function updateOldOnCreate($thingId, $endDate)
    {
        LogHelper::update(ThingAuditorium::class, ['end_date' => $endDate], [
            'thing_id' => $thingId,
            'end_date' => null
        ]);
        return DB::table('thing_auditoriums')
            ->where('thing_id', $thingId)
            ->where('end_date', null)
            ->update(['end_date' => $endDate]);

    }
    public function updateOldOnUpdate($thingId, $oldDate, $newDate)
    {
        LogHelper::update(ThingAuditorium::class, ['end_date' => $newDate], [
            'thing_id' => $thingId,
            'end_date' => $oldDate
        ]);
        return DB::table('thing_auditoriums')
            ->where('thing_id', $thingId)
            ->where('end_date', $oldDate)
            ->update(['end_date' => $newDate]);

    }
    public function updateOldOnDelete($thingId, $date)
    {
        LogHelper::update(ThingAuditorium::class, ['end_date' => null], [
            'thing_id' => $thingId,
            'end_date' => $date
        ]);
        return DB::table('thing_auditoriums')
            ->where('thing_id', $thingId)
            ->where('end_date', $date)
            ->update(['end_date' => null]);

    }

    public function isPossibleToUpdate($id, $thingId, $startDate) : bool
    {
        return DB::table('thing_auditoriums')
            ->where('id', $id)
            ->where('end_date', null)
            ->exists() && !DB::table('thing_auditoriums')
                ->whereNot('id', $id)
                ->where('thing_id', $thingId)
                ->where('start_date', '>', $startDate)
                ->exists();
    }
    public function isPossibleToDelete($id) : bool {
        return DB::table('thing_auditoriums')
            ->where('id', $id)
            ->where('end_date', null)
            ->exists();
    }
}
