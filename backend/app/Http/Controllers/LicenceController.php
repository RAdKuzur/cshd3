<?php

namespace App\Http\Controllers;

use App\Http\Requests\LicenceRequest;
use App\Models\Licence;
use App\Services\LicenceService;
use Illuminate\Http\Request;

class LicenceController extends Controller
{
    private LicenceService $licenceService;
    public function __construct(
        LicenceService $licenceService
    )
    {
        $this->licenceService = $licenceService;
    }

    public function create(LicenceRequest $request){
        $dto = $request->toDTO();
        $this->licenceService->create($dto);
        return response()->json([
            'success' => true
        ], 201);
    }
}
