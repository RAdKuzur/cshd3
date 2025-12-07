<?php

namespace App\Services;



use App\Repositories\PositionRepository;

class PositionService
{
    private PositionRepository $positionRepository;
    public function __construct(
        PositionRepository $positionRepository
    )
    {
        $this->positionRepository = $positionRepository;
    }

    public function index(){
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
    public function get($id){
        $position = $this->positionRepository->get($id);
        return [
            'id' => $position->id,
            'name' => $position->name,
        ];
    }
    public function create($data)
    {
        return $this->positionRepository->create($data);
    }
    public function update($id, $data){
        return $this->positionRepository->update($id, $data);
    }
    public function delete($id){
        return $this->positionRepository->delete($id);
    }
}
