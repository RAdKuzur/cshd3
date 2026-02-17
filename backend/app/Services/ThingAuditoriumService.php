<?php

namespace App\Services;

use App\DTO\HistoryThingDTO;
use App\DTO\ThingAuditoriumDTO;
use App\Repositories\ThingAuditoriumRepository;
use App\Repositories\ThingRepository;
use Illuminate\Support\Facades\DB;

class ThingAuditoriumService
{
    public ThingAuditoriumRepository $thingAuditoriumRepository;
    public ThingRepository $thingRepository;
    public function __construct(
        ThingAuditoriumRepository $thingAuditoriumRepository,
        ThingRepository $thingRepository
    )
    {
        $this->thingAuditoriumRepository = $thingAuditoriumRepository;
        $this->thingRepository = $thingRepository;
    }
    public function all() : array
    {
        $data = [];
        $things = $this->thingRepository->getAllWithThingAuditoriums();
        foreach ($things as $thing) {
            $thingAuditoriums = [];
            foreach ($thing->thingAuditoriums as $thingAuditorium) {
                $thingAuditoriums[] = new ThingAuditoriumDTO(
                    id: $thingAuditorium->id,
                    thing_id: $thingAuditorium->thing_id,
                    auditorium_id: $thingAuditorium->auditorium_id,
                    start_date: $thingAuditorium->start_date,
                    end_date: $thingAuditorium->end_date,
                );
            }
            $data[] = new HistoryThingDTO(
                id: $thing->id,
                name: $thing->name,
                inv_number: $thing->inv_number,
                type: $thing->thing_type_id,
                thingAuditoriums: $thingAuditoriums,
            );
        }
        return $data;
    }

    public function getOne($id)
    {
        $thingAuditorium = $this->thingAuditoriumRepository->get($id);
        return new ThingAuditoriumDTO(
            id: $thingAuditorium->id,
            thing_id: $thingAuditorium->thing_id,
            auditorium_id: $thingAuditorium->auditorium_id,
            start_date: $thingAuditorium->start_date,
            end_date: $thingAuditorium->end_date,
        );
    }

    public function create(ThingAuditoriumDTO $thingAuditoriumDTO)
    {
        DB::beginTransaction();
        try {
            if($this->thingAuditoriumRepository->isPossibleToCreate($thingAuditoriumDTO->thing_id, $thingAuditoriumDTO->start_date)) {
                $this->thingAuditoriumRepository->updateOldOnCreate($thingAuditoriumDTO->thing_id, $thingAuditoriumDTO->start_date);
                $this->thingAuditoriumRepository->create($thingAuditoriumDTO->toArray());
            }
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
        }

    }

    public function update($id, ThingAuditoriumDTO $thingAuditoriumDTO) {
        DB::beginTransaction();
        try {
            if($this->thingAuditoriumRepository->isPossibleToUpdate($id, $thingAuditoriumDTO->thing_id, $thingAuditoriumDTO->start_date)) {
                $oldThingAuditorium = $this->thingAuditoriumRepository->get($id);
                $this->thingAuditoriumRepository->updateOldOnUpdate($thingAuditoriumDTO->thing_id, $oldThingAuditorium->start_date, $thingAuditoriumDTO->start_date);
                $this->thingAuditoriumRepository->update($id, $thingAuditoriumDTO->toArray());
            }

            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
        }
    }

    public function delete($id) {
        DB::beginTransaction();
        try {
            if($this->thingAuditoriumRepository->isPossibleToDelete($id)) {
                $thingAuditorium = $this->thingAuditoriumRepository->get($id);
                $this->thingAuditoriumRepository->updateOldOnDelete($thingAuditorium->thing_id, $thingAuditorium->start_date);
                $this->thingAuditoriumRepository->delete($id);
            }
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
        }
    }
}
