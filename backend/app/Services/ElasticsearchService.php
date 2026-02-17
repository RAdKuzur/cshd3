<?php

namespace App\Services;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;

class ElasticsearchService
{
    protected Client $client;
    public const THING_INDEX = 'things';
    public const NETWORK_THING_INDEX = 'network-things';

    public function __construct()
    {
        try {
            $this->client = ClientBuilder::create()
                ->setHosts([
                    sprintf(
                        '%s://%s:%s',
                        env('ELASTICSEARCH_SCHEME', 'http'),
                        env('ELASTICSEARCH_HOST', 'elasticsearch'),
                        env('ELASTICSEARCH_PORT', '9200')
                    )
                ])
                ->build();
        } catch (\Exception $e) {
            throw new \RuntimeException('Elasticsearch connection failed: ' . $e->getMessage());
        }
    }

    public function getClient(): Client {
        return $this->client;
    }

    public function indexes() : array
    {
        $response = $this->client->indices()->get(['index' => '*']);
        $indices = array_keys($response->asArray());
        return array_values($indices);
    }
    public function exist($index) : bool
    {
        $response = $this->client->indices()->exists(['index' => $index]);
        return $response->getStatusCode() === 200;
    }

    public function create($index): void
    {
        if(!$this->exist($index)) {
            $this->client->indices()->create([
                'index' => $index
            ]);
        }
    }

    public function index($index, $body) {
        if(!$this->exist($index)) {
            $this->create($index);
        }
        $this->client->index([
            'index' => $index,
            'body' => $body
        ]);
    }

    public function search(string $index, $body)
    {
        return $this->client->search([
            'index' => $index,
            'body'  => $body
        ]);
    }

    public function get(string $index, string $id)
    {
        $params = [
            'index' => $index,
            'id'    => $id
        ];

        return $this->client->get($params);
    }
    public function update(string $index, string|int $esId, array $data)
    {
        return $this->client->update([
            'index' => $index,
            'id'    => $esId,
            'body'  => [
                'doc' => $data
            ]
        ]);
    }
    public function updateById(string $index, int $id, array $data)
    {
        $response = $this->client->search([
            'index' => $index,
            'body' => [
                'query' => [
                    'term' => [
                        'id' => $id
                    ]
                ]
            ]
        ]);
        if (empty($response['hits']['hits'])) {
            throw new \Exception("Document with id=$id not found");
        }
        $esId = $response['hits']['hits'][0]['_id'];
        return $this->client->update([
            'index' => $index,
            'id'    => $esId,
            'body'  => [
                'doc' => $data
            ]
        ]);
    }
    public function delete($index){
        $this->client->indices()->delete([
            'index' => $index
        ]);
    }

    public function deleteById($index, $id){
        $this->client->delete([
            'index' => $index,
            'id' => $id
        ]);
    }

    public function deleteByBodyId(string $index, int $bodyId)
    {
        $response = $this->client->search([
            'index' => $index,
            'body' => [
                'query' => [
                    'term' => [
                        'id' => $bodyId
                    ]
                ]
            ]
        ]);
        if (empty($response['hits']['hits'])) {
            throw new \Exception("Document with id=$bodyId not found");
        }
        $esId = $response['hits']['hits'][0]['_id'];
        return $this->client->delete([
            'index' => $index,
            'id'    => $esId
        ]);
    }
}
