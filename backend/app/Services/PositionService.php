<?php

namespace App\Services;



use App\DTO\PositionDTO;
use App\Helpers\LogHelper;
use App\Repositories\PeoplePositionRepository;
use App\Repositories\PositionRepository;
use Illuminate\Support\Facades\DB;

class PositionService
{
    private PositionRepository $positionRepository;
    private PeoplePositionRepository $peoplePositionRepository;
    public function __construct(
        PositionRepository $positionRepository,
        PeoplePositionRepository $peoplePositionRepository
    )
    {
        $this->positionRepository = $positionRepository;
        $this->peoplePositionRepository = $peoplePositionRepository;
    }

    public function all() : array {
        $data = [];
        $positions = $this->positionRepository->getAll();
        foreach($positions as $position){
            $data[] = new PositionDTO(
                id: $position->id,
                name: $position->name,
            );
        }
        return $data;
    }
    public function get($id) : PositionDTO {
        $position = $this->positionRepository->get($id);
        return new PositionDTO(
            id: $position->id,
            name: $position->name,
        );
    }
    public function create($data)
    {
        DB::beginTransaction();
        try {
            $this->positionRepository->create($data);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            LogHelper::error($e->getMessage(), $e->getTraceAsString());
        }
    }
    public function update($id, $data){
        DB::beginTransaction();
        try {
            $this->positionRepository->update($id, $data);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            LogHelper::error($e->getMessage(), $e->getTraceAsString());
        }
    }
    public function delete($id){
        DB::beginTransaction();
        try {
            $position = $this->positionRepository->get($id);
            foreach($position->peoplePositions as $peoplePosition){
                $this->peoplePositionRepository->delete($peoplePosition->id);
            }
            $this->positionRepository->delete($id);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            LogHelper::error($e->getMessage(), $e->getTraceAsString());
        }
    }
}
