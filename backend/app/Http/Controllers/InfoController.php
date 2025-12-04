<?php

namespace App\Http\Controllers;

use App\Dictionaries\ConditionDictionary;
use App\Dictionaries\ThingBalanceDictionary;
use App\Dictionaries\ThingTypeDictionary;
use Illuminate\Http\Request;

class InfoController extends Controller
{
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
}
