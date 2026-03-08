<?php

namespace App\Services;

use App\DTO\CompanyDTO;
use App\Helpers\LogHelper;
use App\Repositories\CompanyRepository;
use App\Repositories\DeviceRepository;
use App\Repositories\ModelRepository;
use App\Repositories\ModelResourceRepository;
use Illuminate\Support\Facades\DB;

class CompanyService
{
    public CompanyRepository $companyRepository;
    public ModelRepository $modelRepository;
    public DeviceRepository $deviceRepository;
    public ModelResourceRepository $modelResourceRepository;
    public function __construct(
        CompanyRepository $companyRepository,
        ModelRepository $modelRepository,
        DeviceRepository $deviceRepository,
        ModelResourceRepository $modelResourceRepository
    )
    {
        $this->companyRepository = $companyRepository;
        $this->modelRepository = $modelRepository;
        $this->deviceRepository = $deviceRepository;
        $this->modelResourceRepository = $modelResourceRepository;
    }
    public function all() : array
    {
        $data = [];
        $companies = $this->companyRepository->getAll();
        foreach ($companies as $company) {
            $data[] = new CompanyDTO(
                id: $company->id,
                name: $company->name,
            );
        }
        return $data;
    }
    public function getOne($id) : CompanyDTO
    {
        $company = $this->companyRepository->getById($id);
        return new CompanyDTO(
            id: $company->id,
            name: $company->name,
        );
    }
    public function create(CompanyDTO $companyDTO) {
        DB::beginTransaction();
        try {
            $this->companyRepository->create($companyDTO->toArray());
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            LogHelper::error($e->getMessage(), $e->getTraceAsString());
        }

    }
    public function update($id, CompanyDTO $companyDTO) {
        DB::beginTransaction();
        try {
            $this->companyRepository->update($id, $companyDTO->toArray());
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
            $company = $this->companyRepository->getById($id);
            foreach($company->models as $model) {
                $model = $this->modelRepository->getById($id);
                foreach($model->devices as $device) {
                    $this->deviceRepository->delete($device->id);
                }
                foreach($model->modelResources as $modelResource) {
                    $this->modelResourceRepository->delete($modelResource->id);
                }
                $this->modelRepository->delete($id);
            }
            $this->companyRepository->delete($id);
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            LogHelper::error($e->getMessage(), $e->getTraceAsString());
        }
    }
}
