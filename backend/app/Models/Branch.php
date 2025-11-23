<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/** @property int $id
 * @property string $name
 *
 * @property PeoplePosition[] $people
 * */
class Branch extends Model
{
    protected $table = 'branches';
    protected $fillable = [
        'name'
    ];
    public function peoplePositions()
    {
        return $this->hasMany(PeoplePosition::class);
    }
}
