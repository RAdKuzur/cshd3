<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/** @property int $id
 * @property int $people_id
 * @property int $position_id
 * @property bool $is_active
 * @property int $branch_id
 *
 * @property People $people
 * @property Position $position
 * @property Branch $branch
*/
class PeoplePosition extends Model
{
    protected $table = 'people_positions';
    protected $fillable = [
        'people_id',
        'position_id',
        'is_active',
        'branch_id'
    ];
    protected $hidden = [

    ];
    public function people(){
        return $this->belongsTo(People::class);
    }
    public function position(){
        return $this->belongsTo(Position::class);
    }
    public function branch(){
        return $this->belongsTo(Branch::class);
    }
}
