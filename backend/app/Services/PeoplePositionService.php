<?php

namespace App\Services;

use App\DTO\HistoryPeopleDTO;
use App\DTO\PeoplePositionDTO;
use App\Repositories\PeoplePositionRepository;
use App\Repositories\PeopleRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PeoplePositionService
{
    public PeoplePositionRepository $peoplePositionRepository;
    public PeopleRepository $peopleRepository;
    public function __construct(
        PeoplePositionRepository $peoplePositionRepository,
        PeopleRepository $peopleRepository
    )
    {
        $this->peoplePositionRepository = $peoplePositionRepository;
        $this->peopleRepository = $peopleRepository;
    }

    public function all() : array
    {
        $data = [];
        $people = $this->peopleRepository->getAllWithPeoplePositions();
        foreach ($people as $person) {
            $peoplePositions = [];
            foreach ($person->peoplePositions as $peoplePosition) {
                $peoplePositions[] = new PeoplePositionDTO(
                    id: $peoplePosition->id,
                    people_id: $peoplePosition->people_id,
                    position_id: $peoplePosition->position_id,
                    branch_id: $peoplePosition->branch_id,
                    start_date: $peoplePosition->start_date,
                    end_date: $peoplePosition->end_date
                );
            }
            $data[] = new HistoryPeopleDTO(
                firstname: $person->firstname,
                surname: $person->surname,
                patronymic: $person->patronymic,
                auditorium_id: $person->auditorium_id,
                peoplePositions: $peoplePositions
            );
        }
        return $data;
    }

    public function getOne($id)
    {
        $peoplePosition = $this->peoplePositionRepository->getById($id);
        return new PeoplePositionDTO(
            id: $peoplePosition->id,
            people_id: $peoplePosition->people_id,
            position_id: $peoplePosition->position_id,
            branch_id: $peoplePosition->branch_id,
            start_date: $peoplePosition->start_date,
            end_date: $peoplePosition->end_date
        );
    }

    public function create(PeoplePositionDTO $peoplePositionDTO)
    {
        DB::beginTransaction();
        try {
            if($this->peoplePositionRepository->isPossibleToCreate($peoplePositionDTO->people_id, $peoplePositionDTO->start_date)) {
                $this->peoplePositionRepository->updateOldOnCreate($peoplePositionDTO->people_id, $peoplePositionDTO->start_date);
                $this->peoplePositionRepository->create($peoplePositionDTO->toArray());
            }
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
        }

    }

    public function update($id, PeoplePositionDTO $peoplePositionDTO) {
        DB::beginTransaction();
        try {
            if($this->peoplePositionRepository->isPossibleToUpdate($id, $peoplePositionDTO->people_id, $peoplePositionDTO->start_date)) {
                $oldPeoplePosition = $this->peoplePositionRepository->getById($id);
                Log::debug(json_encode([$peoplePositionDTO->people_id, $oldPeoplePosition->start_date, $peoplePositionDTO->start_date]));
                $this->peoplePositionRepository->updateOldOnUpdate($peoplePositionDTO->people_id, $oldPeoplePosition->start_date, $peoplePositionDTO->start_date);
                $this->peoplePositionRepository->update($id, $peoplePositionDTO->toArray());
            }
            DB::commit();
        }
        catch (\Exception $e) {
            Log::debug($e->getTraceAsString());
            DB::rollBack();
        }
    }

    public function delete($id) {
        DB::beginTransaction();
        try {
            if($this->peoplePositionRepository->isPossibleToDelete($id)) {
                $peoplePosition = $this->peoplePositionRepository->getById($id);
                $this->peoplePositionRepository->updateOldOnDelete($peoplePosition->people_id, $peoplePosition->start_date);
                $this->peoplePositionRepository->delete($id);
            }
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
        }
    }
}
