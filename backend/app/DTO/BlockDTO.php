<?php

namespace App\DTO;

class BlockDTO implements DTO
{
    public string $url;
    public function __construct(
        string $url
    ){
        $this->url = $url;
    }
    public static function fromArray(array $array)
    {
        // TODO: Implement fromArray() method.
        return new self(
            $array['url']
        );
    }
    public function toArray() : array {
        return [
            'url' => $this->url
        ];
    }
}
