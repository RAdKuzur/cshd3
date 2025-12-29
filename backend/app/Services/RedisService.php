<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;

class RedisService
{
    public function get($key)
    {
        return json_decode(Redis::get($key));
    }
    public function set($key, $data, $ttl = null)
    {
        if ($ttl !== null) {
            Redis::setex($key, $ttl, json_encode($data));
        } else {
            Redis::set($key, json_encode($data));
        }
    }
    public function del($key){
        Redis::del($key);
    }
}
