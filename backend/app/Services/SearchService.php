<?php

namespace App\Services;

use App\Helpers\UrlHelper;

class SearchService
{
    public ElasticsearchService $elasticsearchService;
    public function __construct(
        ElasticsearchService $elasticsearchService
    )
    {
        $this->elasticsearchService = $elasticsearchService;
    }

    public function search(array $query)
    {
        $data = [];
        $indexes = $this->elasticsearchService->indexes();
        foreach ($indexes as $index) {

            $hits = $this->elasticsearchService->search($index, $query)->asObject()->hits->hits;
            foreach ($hits as $hit) {
                $data[] = [
                    'link' => UrlHelper::createUrlFromSearch($index, $hit->_source->id),
                    'attributes' => $hit->_source->attributes
                ];
            }

        }
        return $data;
    }
}
