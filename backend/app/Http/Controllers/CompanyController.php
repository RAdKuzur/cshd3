<?php

namespace App\Http\Controllers;

use App\DTO\CompanyDTO;
use App\Http\Requests\CompanyRequest;
use App\Services\CompanyService;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    private CompanyService $companyService;
    public function __construct(
        CompanyService $companyService
    )
    {
        $this->companyService = $companyService;
    }

    public function all() {
        $data = $this->companyService->all();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function getOne($id) {
        $data = $this->companyService->getOne($id);
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
    public function create(CompanyRequest $request) {
        $dto = $request->toDTO();
        $this->companyService->create($dto);
        return response()->json([
            'success' => true
        ]);
    }
    public function update($id, CompanyRequest $request) {
        $dto = $request->toDTO();
        $this->companyService->update($id, $dto);
        return response()->json([
            'success' => true
        ]);
    }
    public function delete($id) {
        $this->companyService->delete($id);
        return response()->json([
            'success' => true
        ]);
    }
}
