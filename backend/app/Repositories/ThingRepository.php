<?php

namespace App\Repositories;

use App\Dictionaries\ThingBalanceDictionary;
use App\Dictionaries\ThingTypeDictionary;
use App\Helpers\Auth;
use App\Helpers\LogHelper;
use App\Models\Log;
use App\Models\Thing;
use Illuminate\Support\Facades\DB;

class ThingRepository
{
    public function query()
    {
        return Thing::query();
    }
    public function get($id) : Thing
    {
        return Thing::where('id', $id)->first();
    }
    public function getAll(){
        return Thing::all();
    }
    public function getAllWithCurrentAuditorium()
    {
        return Thing::query()
            ->with([
                'parent:id,inv_number',
                'currentAuditorium.auditorium:id'
            ])
            ->get();
    }
    public function getAllWithThingAuditoriums()
    {
        return Thing::with(['thingAuditoriums'])->get();
    }
    public function getElectronics()
    {
        return Thing::query()
            ->whereIn('thing_type_id', ThingTypeDictionary::ELECTRONICS)
            ->with([
                'parent:id,inv_number',
                'currentAuditorium.auditorium:id'
            ])
            ->get();
    }
    public function getFurniture()
    {
        return Thing::query()
            ->whereIn('thing_type_id', ThingTypeDictionary::FURNITURE)
            ->with([
                'parent:id,inv_number',
                'currentAuditorium.auditorium:id'
            ])
            ->get();
    }
    public function betweenYearsQuery($query, $startYear = null, $endYear = null)
    {
        if ($startYear !== null) {
            $query->where('operation_date', '>=', $startYear . '-01-01');
        }
        if ($endYear !== null) {
            $query->where('operation_date', '<=', $endYear . '-12-31');
        }
        return $query;
    }
    public function thingTypeQuery($query, $type)
    {
        return $query->where('thing_type_id', $type);
    }
    public function conditionQuery($query, $condition)
    {
        return $query->where('condition', $condition);
    }
    public function getAllWithRelations()
    {
        return Thing::with([
                'parent:id,inv_number',
                'currentAuditorium.auditorium:id,branch_id'
        ])
        ->get();
    }
    public function create($data)
    {
        LogHelper::insert(Thing::class, $data);
        return DB::table('things')->insertGetId($data);
    }
    public function update($id, $data){
        LogHelper::update(Thing::class, $data, ['id' => $id]);
        return DB::table('things')->where('id', $id)->update($data);
    }
    public function delete($id){
        LogHelper::delete(Thing::class, ['id' => $id]);
        return DB::table('things')->where('id', $id)->delete();
    }

    public function deleteBylistId(array $ids) {
        LogHelper::delete(Thing::class, ['id' => $ids]);
        return DB::table('things')->whereIn('id', $ids)->delete();
    }
}
