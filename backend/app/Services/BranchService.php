<?php

namespace App\Services;

use App\DTO\BranchDTO;
use App\Helpers\LogHelper;
use App\Repositories\AuditoriumRepository;
use App\Repositories\AuditoriumResponsibilityRepository;
use App\Repositories\BranchRepository;
use App\Repositories\OrganizationRepository;
use App\Repositories\PeoplePositionRepository;
use App\Repositories\ThingAuditoriumRepository;
use Illuminate\Support\Facades\DB;

class BranchService
{
    public BranchRepository $branchRepository;
    public OrganizationRepository $organizationRepository;
    public PeoplePositionRepository $peoplePositionRepository;
    public AuditoriumRepository $auditoriumRepository;
    public AuditoriumResponsibilityRepository $auditoriumResponsibilityRepository;
    public ThingAuditoriumRepository $thingAuditoriumRepository;

    public function __construct(
        BranchRepository $branchRepository,
        OrganizationRepository $organizationRepository,
        PeoplePositionRepository $peoplePositionRepository,
        AuditoriumRepository $auditoriumRepository,
        AuditoriumResponsibilityRepository $auditoriumResponsibilityRepository,
        ThingAuditoriumRepository $thingAuditoriumRepository
    )
    {
        $this->branchRepository = $branchRepository;
        $this->organizationRepository = $organizationRepository;
        $this->peoplePositionRepository = $peoplePositionRepository;
        $this->auditoriumRepository = $auditoriumRepository;
        $this->auditoriumResponsibilityRepository = $auditoriumResponsibilityRepository;
        $this->thingAuditoriumRepository = $thingAuditoriumRepository;
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
            $branch = $this->branchRepository->get($id);
            foreach ($branch->peoplePositions as $peoplePosition){
                $this->peoplePositionRepository->delete($id);
            }
            foreach ($branch->auditoriums as $auditorium){
                foreach($auditorium->auditoriumResponsibilities as $auditoriumResponsibility){
                    $this->auditoriumResponsibilityRepository->delete($auditoriumResponsibility->id);
                }
                foreach ($auditorium->thingAuditoriums as $thingAuditorium) {
                    $this->thingAuditoriumRepository->delete($thingAuditorium->id);
                }
                $this->auditoriumRepository->delete($auditorium->id);
            }
            $this->branchRepository->delete($id);
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            LogHelper::error($e->getMessage(), $e->getTraceAsString());
        }

    }
}
