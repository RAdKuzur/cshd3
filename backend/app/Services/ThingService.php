<?php

namespace App\Services;

use App\Dictionaries\ConditionDictionary;
use App\Dictionaries\ThingTypeDictionary;
use App\Repositories\ThingRepository;

class ThingService
{
    private ThingRepository $thingRepository;
    public function __construct(
        ThingRepository $thingRepository
    )
    {
        $this->thingRepository = $thingRepository;
    }

    public function electronics()
    {
        $electronics = $this->thingRepository->getElectronics();
        $data = [];
        foreach ($electronics as $electronic){
            $data[] = [
                'id' => $electronic->id,
                'name' => $electronic->name,
                'inv_number' => $electronic->inv_number,
                'serial_number' => $electronic->serial_number,
                'type' => ThingTypeDictionary::ELECTRONICS[$electronic->thing_type_id],
                'condition' => ConditionDictionary::get($electronic->condition),
                'parent' => $electronic->parent ? $electronic->parent->inv_number : null,
                'operation_date' => $electronic->operation_date,
                'price' => $electronic->price,
                'auditorium_id' => $electronic->auditorium_id,
            ];
        }
        return $data;

    }
    public function simpleElectronics(){
        $electronics = $this->thingRepository->getElectronics();
        $data = [];
        foreach ($electronics as $electronic){
            $data[] = [
                'id' => $electronic->id,
                'inv_number' => $electronic->inv_number,
            ];
        }
        return $data;
    }
    public function get($id)
    {
        $model = $this->thingRepository->get($id);
        return [
            'id' => $model->id,
            'name' => $model->name,
            'inv_number' => $model->inv_number,
            'serial_number' => $model->serial_number,
            'type' => $model->thing_type_id,
            'condition' => $model->condition,
            'thing_parent_id' => $model->thing_parent_id,
            'operation_date' => $model->operation_date,
            'price' => $model->price,
            'comment' => $model->comment,
            'auditorium_id' => $model->auditorium_id,
        ];
    }
    public function create($data)
    {
        $this->thingRepository->create($data);
    }
    public function update($id, $data)
    {
        $this->thingRepository->update($id, $data);
    }
}
