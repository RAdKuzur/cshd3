<?php

namespace App\Http\Controllers;

use App\Dictionaries\ConditionDictionary;
use App\Dictionaries\ThingBalanceDictionary;
use App\Dictionaries\ThingTypeDictionary;
use App\Services\DepartmentService;
use Illuminate\Http\Request;

class InfoController extends Controller
{
    private DepartmentService $departmentService;
    public function __construct(
        DepartmentService $departmentService
    )
    {
        $this->departmentService = $departmentService;
    }

    public function types(){
        $types = ThingTypeDictionary::type();
        $conditions = ConditionDictionary::type();
        return response()->json([
            'success' => true,
            'code' => 200,
            'types' => json_decode(json_encode($types, JSON_FORCE_OBJECT)),
            'conditions' => json_decode(json_encode($conditions, JSON_FORCE_OBJECT)),
        ]);
    }
    public function balance(){
        $balanceTypes = ThingBalanceDictionary::type();
        return response()->json([
            'success' => true,
            'code' => 200,
            'types' => json_decode(json_encode($balanceTypes, JSON_FORCE_OBJECT)),
        ]);
    }
    public function departments(){
        $data = $this->departmentService->index();
        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => $data
        ]);
    }
}
