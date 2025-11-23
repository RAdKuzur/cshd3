<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/* @property int $id */
/* @property string $name */
/* @property PeoplePosition[] $peoplePositions*/
class Position extends Model
{
    protected $table = 'positions';
    protected $fillable = [
        'name'
    ];
    protected $hidden = [

    ];
}
