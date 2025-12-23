<?php

namespace App\Services;

use App\DTO\AuditoriumDTO;
use App\Models\Auditorium;
use App\Models\ThingAuditorium;
use App\Repositories\AuditoriumRepository;
use Illuminate\Support\Facades\DB;

class AuditoriumService
{
    public AuditoriumRepository $auditoriumRepository;
    public function __construct(
        AuditoriumRepository $auditoriumRepository
    )
    {
        $this->auditoriumRepository = $auditoriumRepository;
    }

    public function all() : array
    {
        $data = [];
        $auditoriums = $this->auditoriumRepository->getAll();
        foreach ($auditoriums as $auditorium) {
            $data[] = [
                'id' => $auditorium->id,
                'name' => $auditorium->name,
                'floor' => $auditorium->floor,
                'number' => $auditorium->number,
                'department_id' => $auditorium->department_id,
                'branch_id' => $auditorium->branch_id,
                'comment' => $auditorium->comment,
            ];
        }
        return $data;
    }
    public function map() : array {
        $data = [];
        $auditoriums = $this->auditoriumRepository->getAll();
        foreach ($auditoriums as $auditorium) {
            $things = [];
            $employees = [];
            foreach ($auditorium->getActualThings() as $thingAuditorium) {
                $things[] = [
                    'id' => $thingAuditorium->thing->id,
                    'name' => $thingAuditorium->thing->name,
                    'inv_number' => $thingAuditorium->thing->inv_number,
                    'thing_type_id' => $thingAuditorium->thing->thing_type_id,
                    'condition' => $thingAuditorium->thing->condition,
                    'serial_number' => $thingAuditorium->thing->serial_number,
                    'balance' => $thingAuditorium->thing->balance
                ];
            }
            foreach($auditorium->people as $person){
                $employees[] = [
                    'fio' => $person->getFullFio(),
                    'position' => $person->getPosition()->name,
                ];
            }
            $data[] = [
                'auditorium_id' => $auditorium->id,
                'auditorium_name' => $auditorium->name,
                'comment' => $auditorium->comment,
                'floor' => $auditorium->floor,
                'branch_id' => $auditorium->branch_id,
                'things' => $things,
                'employees' => $employees
            ];
        }
        return $data;
    }
    public function create(AuditoriumDTO $dto){
        DB::beginTransaction();
        try {
            $this->auditoriumRepository->create($dto->toArray());
            DB::commit();
        }
        catch (\Exception $e){
            DB::rollBack();
        }
    }
    public function update($id, AuditoriumDTO $dto){
        DB::beginTransaction();
        try {
            $this->auditoriumRepository->update($id, $dto->toArray());
            DB::commit();
        }
        catch (\Exception $e){
            DB::rollBack();
        }
    }
    public function delete($id){
        DB::beginTransaction();
        try {
            $this->auditoriumRepository->delete($id);
            DB::commit();
        }
        catch (\Exception $e){
            DB::rollBack();
        }
    }
}
