<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * @property int $id
 * @property string $refresh_token
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $expires_at
 * @property string|null $device_id
 * @property bool $is_revoked
 * @property string $user_agent
 * @property string|null $ip_address
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @property User $user
 */
class Token extends Model
{
    protected $fillable = [
        'user_id',
        'refresh_token',
        'expires_at',
        'user_agent',
        'ip_address',
        'device_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'refresh_token',
    ];
    public function toRevoke(){
        $this->is_revoke = true;
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
