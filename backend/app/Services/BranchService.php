<?php

namespace App\Services;

use App\DTO\BranchDTO;
use App\Helpers\LogHelper;
use App\Repositories\BranchRepository;
use App\Repositories\OrganizationRepository;
use Illuminate\Support\Facades\DB;

class BranchService
{
    public BranchRepository $branchRepository;
    public OrganizationRepository $organizationRepository;
    public function __construct(
        BranchRepository $branchRepository,
        OrganizationRepository $organizationRepository
    )
    {
        $this->branchRepository = $branchRepository;
        $this->organizationRepository = $organizationRepository;
    }

    public function all() : array {
        $data = [];
        $branches = $this->branchRepository->getAll();
        foreach ($branches as $branch){
            $data[] = new BranchDTO(
                id: $branch->id,
                name: $branch->name,
                organization_id: $branch->organization_id
            );
        }
        return $data;
    }
    public function getOne(int $id) : BranchDTO {
        $branch = $this->branchRepository->get($id);
        return new BranchDTO(
            id: $branch->id,
            name: $branch->name,
            organization_id: $branch->organization_id
        );
    }
    public function create($data){
        DB::beginTransaction();
        try {
            $this->branchRepository->create(array_merge($data, [
                'organization_id' => $this->organizationRepository->getMainOrganization()->id
            ]));
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            LogHelper::error($e->getMessage(), $e->getTraceAsString());
        }
    }
    public function update($id, $data){
        DB::beginTransaction();
        try {
            $this->branchRepository->update($id, $data);
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
            $this->branchRepository->delete($id);
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            LogHelper::error($e->getMessage(), $e->getTraceAsString());
        }

    }
}
