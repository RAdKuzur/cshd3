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
    public function create($data)
    {
        $this->thingRepository->create($data);
    }
}
