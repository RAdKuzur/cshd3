<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/** @property  int $id
 * @property $start_time
 * @property $end_time
 * @property $status
 * */
class TechWork extends Model
{
    public const ACTIVE = 1;
    public const INACTIVE = 2;

    protected $table = 'tech_works';

    protected $fillable = [
        'start_time',
        'end_time',
        'status'
    ];
}
