<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/** @property int $id
 * @property string $name
 * @property int $organization_id
 *
 * @property PeoplePosition[] $people
 * @property Organization $organization
 * */
class Branch extends Model
{
    protected $table = 'branches';
    protected $fillable = [
        'name',
        'organization_id'
    ];
    public function peoplePositions()
    {
        return $this->hasMany(PeoplePosition::class);
    }
    public function organization(){
        return $this->belongsTo(Organization::class);
    }
}
