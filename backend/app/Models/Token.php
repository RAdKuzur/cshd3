<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $fillable = [
        'user_id',
        'refresh_token',
        'user_id',
        'expires_at',
        'user_agent',
        'ip_address'
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
}
