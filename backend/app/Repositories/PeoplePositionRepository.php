<?php

namespace App\Repositories;

use App\Helpers\Auth;
use App\Helpers\LogHelper;
use App\Models\Log;
use App\Models\PeoplePosition;
use Illuminate\Support\Facades\DB;

class PeoplePositionRepository
{
    public function getAll()
    {
        return PeoplePosition::all();
    }
    public function getById($id) : PeoplePosition
    {
        return PeoplePosition::find($id);
    }

    public function getByBranch($branchId){
        return PeoplePosition::where('branch_id', $branchId)->get();
    }
    public function getByActiveBranchStaff($branchId){
        return PeoplePosition::where('branch_id', $branchId)->where('end_date', null)->get();
    }
    public function create($data)
    {
        LogHelper::insert(PeoplePosition::class, $data);
        return DB::table('people_positions')->insertGetId($data);
    }

    public function update($id, $data){
        LogHelper::update(PeoplePosition::class, $data, ['id' => $id]);
        DB::table('people_positions')->where('id', $id)->update($data);
    }

    public function delete($id){
        LogHelper::delete(PeoplePosition::class, ['id' => $id]);
        return DB::table('people_positions')->where('id', $id)->delete();
    }

    public function isPossibleToCreate($peopleId, $startDate) : bool
    {
        return !DB::table('people_positions')
                ->where('people_id', $peopleId)
                ->where('start_date', '>', $startDate)
                ->exists();
    }

    public function updateOldOnCreate($peopleId, $endDate)
    {
        LogHelper::update(PeoplePosition::class, ['end_date' => $endDate], [
            'people_id' => $peopleId,
            'end_date' => null
        ]);
        return DB::table('people_positions')
            ->where('people_id', $peopleId)
            ->where('end_date', null)
            ->update(['end_date' => $endDate]);

    }
    public function updateOldOnUpdate($peopleId, $oldDate, $newDate)
    {
        LogHelper::update(PeoplePosition::class, ['end_date' => $newDate], [
            'people_id' => $peopleId,
            'end_date' => $oldDate
        ]);
        return DB::table('people_positions')
            ->where('people_id', $peopleId)
            ->where('end_date', $oldDate)
            ->update(['end_date' => $newDate]);

    }
    public function updateOldOnDelete($peopleId, $date)
    {
        LogHelper::update(PeoplePosition::class, ['end_date' => null], [
            'people_id' => $peopleId,
            'end_date' => $date
        ]);
        return DB::table('people_positions')
            ->where('people_id', $peopleId)
            ->where('end_date', $date)
            ->update(['end_date' => null]);

    }

    public function isPossibleToUpdate($id, $peopleId, $startDate) : bool
    {
        return DB::table('people_positions')
                ->where('id', $id)
                ->where('end_date', null)
                ->exists() && !DB::table('people_positions')
                ->whereNot('id', $id)
                ->where('people_id', $peopleId)
                ->where('start_date', '>', $startDate)
                ->exists();
    }
    public function isPossibleToDelete($id) : bool {
        return DB::table('people_positions')
            ->where('id', $id)
            ->where('end_date', null)
            ->exists();
    }
}
