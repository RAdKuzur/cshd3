<?php

namespace App\Services;

use App\DTO\CompanyDTO;
use App\Repositories\CompanyRepository;

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
        $this->companyRepository->create($companyDTO->toArray());
    }
    public function update($id, CompanyDTO $companyDTO) {
        $this->companyRepository->update($id, $companyDTO->toArray());
    }
    public function delete($id) {
        $this->companyRepository->delete($id);
    }
}
