<?php

namespace App\Services;

use App\DTO\CompanyDTO;
use App\Repositories\CompanyRepository;
use Illuminate\Support\Facades\DB;

class CompanyService
{
    public CompanyRepository $companyRepository;
    public function __construct(
        CompanyRepository $companyRepository
    )
    {
        $this->companyRepository = $companyRepository;
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
        }

    }
    public function delete($id) {
        DB::beginTransaction();
        try {
            $this->companyRepository->delete($id);
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
        }
    }
}
