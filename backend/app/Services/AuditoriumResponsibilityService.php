<?php

namespace App\Services;

use App\DTO\AuditoriumResponsibilityDTO;
use App\DTO\HistoryAuditoriumDTO;
use App\Helpers\LogHelper;
use App\Http\Requests\AuditoriumResponsibilityRequest;
use App\Repositories\AuditoriumRepository;
use App\Repositories\AuditoriumResponsibilityRepository;
use Illuminate\Support\Facades\DB;

class AuditoriumResponsibilityService
{
    public AuditoriumResponsibilityRepository $auditoriumResponsibilityRepository;
    public AuditoriumRepository $auditoriumRepository;
    public function __construct(
        AuditoriumResponsibilityRepository $auditoriumResponsibilityRepository,
        AuditoriumRepository $auditoriumRepository
    )
    {
        $this->auditoriumResponsibilityRepository = $auditoriumResponsibilityRepository;
        $this->auditoriumRepository = $auditoriumRepository;
    }
    public function all() : array
    {
        $data = [];
        $auditoriums = $this->auditoriumRepository->getAllWithAuditoriumResponsibilities();
        foreach ($auditoriums as $auditorium) {
            $auditoriumResponsibilities = [];
            foreach ($auditorium->auditoriumResponsibilities as $auditoriumResponsibility) {
                $auditoriumResponsibilities[] = new AuditoriumResponsibilityDTO(
                    id: $auditoriumResponsibility->id,
                    people_id: $auditoriumResponsibility->people_id,
                    auditorium_id: $auditoriumResponsibility->auditorium_id,
                    start_date: $auditoriumResponsibility->start_date,
                    end_date: $auditoriumResponsibility->end_date,
                );
            }
            $data[] = new HistoryAuditoriumDTO(
                id: $auditorium->id,
                name: $auditorium->name,
                number: $auditorium->number,
                floor: $auditorium->floor,
                branch_id: $auditorium->branch_id,
                auditoriumResponsibilities: $auditoriumResponsibilities,
            );
        }
        return $data;
    }

    public function getOne($id)
    {
        $auditoriumResponsibility = $this->auditoriumResponsibilityRepository->get($id);
        return new AuditoriumResponsibilityDTO(
            id: $auditoriumResponsibility->id,
            people_id: $auditoriumResponsibility->people_id,
            auditorium_id: $auditoriumResponsibility->auditorium_id,
            start_date: $auditoriumResponsibility->start_date,
            end_date: $auditoriumResponsibility->end_date,
        );
    }

    public function create(AuditoriumResponsibilityDTO $auditoriumResponsibilityDTO)
    {
        DB::beginTransaction();
        try {
            if($this->auditoriumResponsibilityRepository->isPossibleToCreate($auditoriumResponsibilityDTO->auditorium_id, $auditoriumResponsibilityDTO->start_date)) {
                $this->auditoriumResponsibilityRepository->updateOldOnCreate($auditoriumResponsibilityDTO->auditorium_id, $auditoriumResponsibilityDTO->start_date);
                $this->auditoriumResponsibilityRepository->create($auditoriumResponsibilityDTO->toArray());
            }
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            LogHelper::error($e->getMessage(), $e->getTraceAsString());
        }

    }

    public function update($id, AuditoriumResponsibilityDTO $auditoriumResponsibilityDTO) {
        DB::beginTransaction();
        try {
            if($this->auditoriumResponsibilityRepository->isPossibleToUpdate($id, $auditoriumResponsibilityDTO->auditorium_id, $auditoriumResponsibilityDTO->start_date)) {
                $oldAuditoriumResponsibility = $this->auditoriumResponsibilityRepository->get($id);
                $this->auditoriumResponsibilityRepository->updateOldOnUpdate($auditoriumResponsibilityDTO->auditorium_id, $oldAuditoriumResponsibility->start_date, $auditoriumResponsibilityDTO->start_date);
                $this->auditoriumResponsibilityRepository->update($id, $auditoriumResponsibilityDTO->toArray());
            }

            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            LogHelper::error($e->getMessage(), $e->getTraceAsString());
        }
    }

    public function delete($id) {
        DB::beginTransaction();
        try {
            if($this->auditoriumResponsibilityRepository->isPossibleToDelete($id)) {
                $auditoriumResponsibility = $this->auditoriumResponsibilityRepository->get($id);
                $this->auditoriumResponsibilityRepository->updateOldOnDelete($auditoriumResponsibility->auditorium_id, $auditoriumResponsibility->start_date);
                $this->auditoriumResponsibilityRepository->delete($id);
            }
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            LogHelper::error($e->getMessage(), $e->getTraceAsString());
        }
    }
}
