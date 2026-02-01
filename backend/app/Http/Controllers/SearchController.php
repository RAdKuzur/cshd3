<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Services\SearchService;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Search;

class SearchController extends Controller
{
    private SearchService $searchService;
    public function __construct(
        SearchService $searchService
    )
    {
        $this->searchService = $searchService;
    }
    public function search(SearchRequest $request){
        $data = $this->searchService->search([
            'query' => [
                'wildcard' => [
                    'comment' => [
                        'value' => '*' . $request->binding() . '*'
                    ]
                ]
            ],
            'size' => 10000
        ]);
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
