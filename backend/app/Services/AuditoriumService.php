<?php

namespace App\Services;

use App\DTO\AuditoriumDTO;
use App\DTO\AuditoriumMapDTO;
use App\Models\Auditorium;
use App\Models\ThingAuditorium;
use App\Repositories\AuditoriumRepository;
use App\Repositories\AuditoriumResponsibilityRepository;
use App\Repositories\ThingAuditoriumRepository;
use Illuminate\Support\Facades\DB;

class AuditoriumService
{
    public AuditoriumRepository $auditoriumRepository;
    private AuditoriumResponsibilityRepository $auditoriumResponsibilityRepository;
    private ThingAuditoriumRepository $thingAuditoriumRepository;
    public function __construct(
        AuditoriumRepository $auditoriumRepository,
        AuditoriumResponsibilityRepository $auditoriumResponsibilityRepository,
        ThingAuditoriumRepository $thingAuditoriumRepository
    )
    {
        $this->auditoriumRepository = $auditoriumRepository;
        $this->auditoriumResponsibilityRepository = $auditoriumResponsibilityRepository;
        $this->thingAuditoriumRepository = $thingAuditoriumRepository;
    }

    public function all() : array
    {
        $data = [];
        $auditoriums = $this->auditoriumRepository->getAll();
        foreach ($auditoriums as $auditorium) {
            $data[] = new AuditoriumDTO(
                id: $auditorium->id,
                name: $auditorium->name,
                number: $auditorium->number,
                floor: $auditorium->floor,
                department_id: $auditorium->department_id,
                branch_id: $auditorium->branch_id,
                comment: $auditorium->comment,
            );
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
                    'position' => $person->getPosition() ? $person->getPosition()->name : null,
                ];
            }
            $data[] = new AuditoriumMapDTO(
                auditorium_id: $auditorium->id,
                auditorium_name: $auditorium->name,
                comment: $auditorium->comment,
                floor: $auditorium->floor,
                branch_id: $auditorium->branch_id,
                things: $things,
                employees: $employees
            );
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
            $auditorium = $this->auditoriumRepository->get($id);
            foreach($auditorium->auditoriumResponsibilities as $auditoriumResponsibility){
                $this->auditoriumResponsibilityRepository->delete($auditoriumResponsibility->id);
            }
            foreach ($auditorium->thingAuditoriums as $thingAuditorium) {
                $this->thingAuditoriumRepository->delete($thingAuditorium->id);
            }
            $this->auditoriumRepository->delete($id);
            DB::commit();
        }
        catch (\Exception $e){
            DB::rollBack();
        }
    }
}
