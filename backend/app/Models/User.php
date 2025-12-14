<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

/** @property $id
* @property string $username
* @property string $email
* @property string $password
* @property $email_verified_at
* @property Permission[] $permissions
* @property People $people
*/

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
//    public function getJWTIdentifier()
//    {
//        return $this->getKey();
//    }
//    public function getJWTCustomClaims()
//    {
//        return [];
//    }
    public function permissions(){
        return $this->hasMany(Permission::class);
    }
    public function people(){
        return $this->hasOne(People::class);
    }
}
