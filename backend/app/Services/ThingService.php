<?php

namespace App\Services;

use App\Dictionaries\ConditionDictionary;
use App\Dictionaries\ThingBalanceDictionary;
use App\Dictionaries\ThingTypeDictionary;
use App\DTO\Thing\ThingDTO;
use App\DTO\Thing\UpdateThingDTO;
use App\Models\Thing;
use App\Repositories\BranchRepository;
use App\Repositories\FileRepository;
use App\Repositories\NetworkThingRepository;
use App\Repositories\ThingAuditoriumRepository;
use App\Repositories\ThingRepository;
use App\Repositories\TransferActRepository;
use App\Repositories\TransferActThingRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ThingService
{
    public ThingRepository $thingRepository;
    public TransferActRepository $transferActRepository;
    public ThingAuditoriumRepository $thingAuditoriumRepository;
    public BranchRepository $branchRepository;
    public TransferActThingRepository $transferActThingRepository;
    public NetworkThingRepository $networkThingRepository;
    public FileRepository $fileRepository;
    public function __construct(
        ThingRepository $thingRepository,
        TransferActRepository $transferActRepository,
        ThingAuditoriumRepository $thingAuditoriumRepository,
        BranchRepository $branchRepository,
        TransferActThingRepository $transferActThingRepository,
        NetworkThingRepository $networkThingRepository,
        FileRepository $fileRepository
    ) {
        $this->thingRepository = $thingRepository;
        $this->transferActRepository = $transferActRepository;
        $this->thingAuditoriumRepository = $thingAuditoriumRepository;
        $this->branchRepository = $branchRepository;
        $this->transferActThingRepository = $transferActThingRepository;
        $this->networkThingRepository = $networkThingRepository;
        $this->fileRepository = $fileRepository;
    }

    public function electronics(): array
    {
        return $this->thingRepository
            ->getElectronics()
            ->map(fn ($electronic) => new ThingDTO(
                id: $electronic->id,
                name: $electronic->name,
                serial_number: $electronic->serial_number,
                inv_number: $electronic->inv_number,
                operation_date: $electronic->operation_date,
                thing_type_id: $electronic->thing_type_id,
                thing_parent_id: $electronic->parent?->inv_number,
                condition: $electronic->condition,
                balance: $electronic->balance,
                auditorium_id: $electronic->currentAuditorium?->auditorium?->id,
                price: $electronic->price,
                is_blocked: $electronic->is_blocked,
            ))
            ->all();
    }

    public function furniture() : array
    {
        return $this->thingRepository
            ->getFurniture()
            ->map(fn ($furniture) => new ThingDTO(
                id: $furniture->id,
                name: $furniture->name,
                serial_number: $furniture->serial_number,
                inv_number: $furniture->inv_number,
                operation_date: $furniture->operation_date,
                thing_type_id: $furniture->thing_type_id,
                thing_parent_id: $furniture->parent?->inv_number,
                condition: $furniture->condition,
                balance: $furniture->balance,
                auditorium_id: $furniture->currentAuditorium?->auditorium?->id,
                price: $furniture->price,
                is_blocked: $furniture->is_blocked,
            ))
            ->all();
    }
    public function simpleThings(): array
    {
        $electronics = $this->thingRepository->getAll();
        $data = [];
        foreach ($electronics as $electronic) {
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
        return new ThingDTO(
            id: $model->id,
            name: $model->name,
            serial_number: $model->serial_number,
            inv_number: $model->inv_number,
            operation_date: $model->operation_date,
            thing_type_id: $model->thing_type_id,
            thing_parent_id: $model->thing_parent_id,
            condition: $model->condition,
            balance: $model->balance,
            auditorium_id: $model->getCurrentLocation() ? $model->getCurrentLocation()->id : null,
            price: $model->price,
            comment: $model->comment,
            is_composite: $model->is_composite,
            is_blocked: $model->is_blocked,
            //children: $model->children,
        );
    }

    public function compositeCreate(ThingDTO $dto)
    {
        DB::beginTransaction();
        try {
            $thingId = $this->thingRepository->create(array_merge($dto->toArray(), [
                'is_blocked' => Thing::NOT_BLOCKED,
                'balance' => ThingBalanceDictionary::NONE_BALANCE
            ]));

            $this->thingAuditoriumRepository->create([
                'auditorium_id' => $dto->auditorium_id,
                'thing_id' => $thingId,
                'start_date' => now(),
                'end_date' => null
            ]);

            $childIds = [];
            if ($dto->is_composite && !empty($dto->children)) {
                foreach ($dto->children as $childDTO) {

                    $childData = $childDTO->toArray();
                    $childData['thing_parent_id'] = $thingId;
                    $childData['is_blocked'] = Thing::NOT_BLOCKED;

                    $childId = $this->thingRepository->create($childData);
                    $this->thingAuditoriumRepository->create([
                        'auditorium_id' => $dto->auditorium_id,
                        'thing_id' => $childId,
                        'start_date' => now(),
                        'end_date' => null
                    ]);
                    $childIds[] = $childId;
                }
            }

            DB::commit();
            return [
                'id' => $thingId,
                'children' => $childIds,
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Composite create failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return [
                'error' => 'Error'
            ];
        }
    }
    public function getActualAll(): array
    {
        $data = [];
        $things = $this->thingRepository->getAll();
        foreach ($things as $thing) {
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

    public function getFreeThings(): array
    {
        $data = [];
        $things = $this->thingRepository->getAll();
        foreach ($things as $thing) {
            if (
                !$thing->getActualMaster() && $thing->balance == ThingBalanceDictionary::NONE_BALANCE
                && $thing->is_blocked == Thing::NOT_BLOCKED
            ) {
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

    public function getPersonThings($id): array
    {
        $data = [];
        $things = $this->thingRepository->getAll();
        foreach ($things as $thing) {
            if (
                $thing->getActualMaster() && $thing->getActualMaster()->id == $id
                && $thing->is_blocked == Thing::NOT_BLOCKED
            ) {
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
    public function getTransferActThings($id): array
    {
        $data = [];
        $transferAct = $this->transferActRepository->get($id);
        if ($transferAct) {
            foreach ($transferAct->transferActThings as $transferActThing) {
                if ($transferActThing->thing) {
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
    public function create(ThingDTO $thing)
    {
        DB::beginTransaction();
        try {
            $thingId = $this->thingRepository->create(array_merge($thing->toArray(), [
                'is_blocked' => Thing::NOT_BLOCKED,
                'balance' => ThingBalanceDictionary::NONE_BALANCE,
            ]));
            $this->thingAuditoriumRepository->create([
                'auditorium_id' => $thing->auditorium_id,
                'thing_id' => $thingId,
                'start_date' => now(),
                'end_date' => null
            ]);
            DB::commit();
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            DB::rollBack();
        }
    }

    public function update(int $id, UpdateThingDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {

            $thing = $this->thingRepository->get($id);

            //            TODO edit
            $thing->update([
                'condition' => $dto->condition,
                'comment' => $dto->comment,
            ]);

            if (!$thing->is_composite) {
                return;
            }

            if (!empty($dto->childrenToDelete)) {
                $this->thingAuditoriumRepository->deleteByListId($dto->childrenToDelete);
                $this->thingRepository->deleteBylistId($dto->childrenToDelete);
            }

            foreach ($dto->childrenToCreate as $childDTO) {
                $childData = $childDTO->toArray();
                $childData['thing_parent_id'] = $id;

                $this->thingRepository->create(array_merge($childData, [
                    'is_blocked' => Thing::NOT_BLOCKED,
                    'balance' => ThingBalanceDictionary::NONE_BALANCE,
                ]));
            }
        });
    }
    public function filterArm($branchId, $startDate, $endDate)
    {
        $data = [];
        $branch = $this->branchRepository->get($branchId);
        foreach ($branch->auditoriums as $auditorium) {
            foreach($auditorium->getActualThings() as $thingAuditorium) {
                if($thingAuditorium->thing->operation_date > $startDate && $thingAuditorium->thing->operation_date < $endDate &&
                    $thingAuditorium->thing->thing_type_id == ThingTypeDictionary::ARM) {
                    $thing = $thingAuditorium->thing;
                    $data[] = new ThingDTO(
                        id: $thing->id,
                        name: $thing->name,
                        inv_number: $thing->inv_number,
                        operation_date: $thing->operation_date,
                        thing_type_id: $thing->thing_type_id,
                        thing_parent_id: $thing->parent ? $thing->parent->inv_number : null,
                        condition: $thing->condition,
                        balance: $thing->balance,
                        auditorium_id: $thing->getCurrentLocation() ? $thing->getCurrentLocation()->id : null,
                        price: $thing->price,
                        comment: $thing->comment,
                        is_blocked: $thing->is_blocked,
                    );
                }
            }
        }
        return $data;
    }
    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $thing = $this->thingRepository->get($id);
            foreach ($thing->thingAuditoriums as $thingAuditorium) {
                $this->thingAuditoriumRepository->delete($thingAuditorium->id);
            }
            foreach ($thing->transferActThings as $transferActThing) {
                $this->transferActThingRepository->delete($transferActThing->id);
            }
            foreach($thing->networkThings as $networkThing) {
                $this->networkThingRepository->delete($networkThing->id);
            }
            $files = $this->fileRepository->getFiles('things', $thing->id);
            foreach ($files as $file) {
                $this->fileRepository->delete($file->id);
            }
            $this->thingRepository->delete($id);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }

    }
}
