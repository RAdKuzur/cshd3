<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** @property int $id
* @property string $code
* @property $expires_at
* @property int $is_revoked
* */
class Licence extends Model
{
    protected $table = 'licences';

    protected $fillable = [
        'code',
        'expires_at',
        'is_revoked'
    ];
}
