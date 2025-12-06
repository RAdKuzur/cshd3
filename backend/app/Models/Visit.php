<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * @property int $id
 * @property string $url
 * @property string $ip_address
 * @property string $host
 * @property string $request_method
 * @property \Illuminate\Support\Carbon $request_time
 * @property string $user_agent
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class Visit extends Model
{
    protected $fillable = [
        'url',
        'route',
        'ip_address',
        'user_agent',
        'host',
        'request_method',
        'request_time',
    ];
    protected $hidden = [
    ];
}
