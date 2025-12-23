<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/** @property int $id
 * @property string $name
 * @property string $number
 * @property int $floor
 * @property int $department_id
 * @property int $branch_id
 * @property string $comment
 *
 * @property Department $department
 * @property People[] $people
 * @property AuditoriumResponsibility[] $auditoriumResponsibilities
 * @property Branch $branch
 *
 * @property ThingAuditorium[] $thingAuditoriums
 */
class Auditorium extends Model
{
    protected $table = 'auditoriums';
    protected $fillable = [
        'name',
        'number',
        'floor',
        'department_id',
        'branch_id'
    ];
    public function department(){
        return $this->belongsTo(Department::class);
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function people(){
        return $this->hasMany(People::class);
    }
    public function auditoriumResponsibilities(){
        return $this->hasMany(AuditoriumResponsibility::class);
    }

    public function thingAuditoriums(){
        return $this->hasMany(ThingAuditorium::class);
    }
    /**
     * @return ThingAuditorium[]
     */
    public function getActualThings()
    {
        return $this->thingAuditoriums()->where('end_date', null)->get();
    }
}
