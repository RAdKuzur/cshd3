<?php

namespace App\Services;



use App\Repositories\PositionRepository;
use Illuminate\Support\Facades\DB;

class PositionService
{
    private PositionRepository $positionRepository;
    public function __construct(
        PositionRepository $positionRepository
    )
    {
        $this->positionRepository = $positionRepository;
    }

    public function all() : array {
        $data = [];
        $positions = $this->positionRepository->getAll();
        foreach($positions as $position){
            $data[] = [
                'id' => $position->id,
                'name' => $position->name,
            ];
        }
        return $data;
    }
    public function get($id) : array {
        $position = $this->positionRepository->get($id);
        return [
            'id' => $position->id,
            'name' => $position->name,
        ];
    }
    public function create($data)
    {
        DB::beginTransaction();
        try {
            $this->positionRepository->create($data);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
    public function update($id, $data){
        DB::beginTransaction();
        try {
            $this->positionRepository->update($id, $data);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
    public function delete($id){
        DB::beginTransaction();
        try {
            $this->positionRepository->delete($id);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
}
