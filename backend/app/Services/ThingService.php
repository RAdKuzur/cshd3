<?php

namespace App\Services;

use App\DTO\Thing\ThingDTO;
use App\DTO\Thing\UpdateThingDTO;
use App\Repositories\ThingRepository;
use App\Repositories\TransferActRepository;
use Illuminate\Support\Facades\DB;

class ThingService
{
    private ThingRepository $thingRepository;
    private TransferActRepository $transferActRepository;
    public function __construct(
        ThingRepository $thingRepository,
        TransferActRepository $transferActRepository
    )
    {
        $this->thingRepository = $thingRepository;
        $this->transferActRepository = $transferActRepository;
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
                'type' => $electronic->thing_type_id ? $electronic->thing_type_id : null,
                'condition' => $electronic->condition,
                'parent' => $electronic->parent ? $electronic->parent->inv_number : null,
                'operation_date' => $electronic->operation_date,
                'price' => $electronic->price,
                'auditorium_id' => $electronic->getCurrentLocation() ? $electronic->getCurrentLocation()->id : null,
                'balance' => $electronic->balance,
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
            'auditorium_id' => $model->getCurrentLocation()->id,
            'balance' => $model->balance,
        ];
    }

    public function compositeCreate(ThingDTO $dto) {
        DB::beginTransaction();
        try {
            $thinId = $this->thingRepository->create($dto->toArray());


            if ($dto->is_composite && !empty($dto->children)) {
                foreach ($dto->children as $childDTO) {

                    $childData = $childDTO->toArray();
                    $childData['thing_parent_id'] = $thinId;

                    $this->thingRepository->create($childData);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    public function getActualAll()
    {
        $data = [];
        $things = $this->thingRepository->getAll();
        foreach ($things as $thing){
            $data[] = new ThingDTO(
                id: $thing->id,
                name: $thing->name,
                inv_number: $thing->inv_number,
                operation_date: $thing->operation_date,
                thing_type_id: $thing->thing_type_id,
                price: $thing->price,
                comment: $thing->comment,
            );
        }
        return $data;
    }

    public function free()
    {
        $data = [];
        $things = $this->thingRepository->getAll();
        foreach ($things as $thing){
            if(!$thing->getActualMaster()) {
                $data[] = new ThingDTO(
                    id: $thing->id,
                    name: $thing->name,
                    inv_number: $thing->inv_number,
                    operation_date: $thing->operation_date,
                    thing_type_id: $thing->thing_type_id,
                    price: $thing->price,
                    comment: $thing->comment
                );
            }
        }
        return $data;
    }

    public function getPersonThings($id)
    {
        $data = [];
        $things = $this->thingRepository->getAll();
        foreach ($things as $thing){
            if($thing->getActualMaster() && $thing->getActualMaster()->id == $id){
                $data[] = new ThingDTO(
                    id: $thing->id,
                    name: $thing->name,
                    inv_number: $thing->inv_number,
                    operation_date: $thing->operation_date,
                    thing_type_id: $thing->thing_type_id,
                    price: $thing->price,
                    comment: $thing->comment,
                );
            }
        }
        return $data;
    }
    public function getTransferActThings($id)
    {
        $data = [];
        $transferAct = $this->transferActRepository->get($id);
        if($transferAct){
            foreach ($transferAct->transferActThings as $transferActThing){
                if($transferActThing->thing) {
                    $data[] = new ThingDTO(
                        id: $transferActThing->thing->id,
                        name: $transferActThing->thing->name,
                        inv_number: $transferActThing->thing->inv_number,
                        operation_date: $transferActThing->thing->operation_date,
                        thing_type_id: $transferActThing->thing->thing_type_id,
                        price: $transferActThing->thing->price,
                        comment: $transferActThing->thing->comment,
                    );
                }
            }
        }
        return $data;
    }
    public function create($data)
    {
        DB::beginTransaction();
        try {
            $this->thingRepository->create($data);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    public function update(int $id, UpdateThingDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {

            $thing = Thing::lockForUpdate()->findOrFail($id);

            $thing->update([
                'condition' => $dto->condition,
                'comment' => $dto->comment,
            ]);

            if (!$thing->is_composite) {
                return;
            }

            if (!empty($dto->childrenToDelete)) {
                Thing::whereIn('id', $dto->childrenToDelete)
                    ->where('parent_id', $thing->id)
                    ->delete();
            }

            foreach ($dto->childrenToCreate as $childDTO) {
                Thing::create([
                    'name' => $childDTO->name,
                    'thing_type_id' => $childDTO->thing_type_id,
                    'price' => $childDTO->price,
                    'parent_id' => $thing->id,
                ]);
            }
        });
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $this->thingRepository->delete($id);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }

    }
}
