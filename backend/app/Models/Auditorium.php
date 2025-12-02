<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/** @property int $id
 * @property string $name
 * @property string $number
 * @property int $floor
 * @property int $department_id
 *
 * @property Department $department
 * @property People[] $people
 * @property Thing[] $things
 * @property AuditoriumResponsibility[] $auditoriumResponsibilities
 */
class Auditorium extends Model
{
    protected $table = 'auditoriums';
    protected $fillable = [
        'name',
        'number',
        'floor',
        'department_id'
    ];
    public function department(){
        return $this->belongsTo(Department::class);
    }
    public function people(){
        return $this->hasMany(People::class);
    }
    public function auditoriumResponsibilities(){
        return $this->hasMany(AuditoriumResponsibility::class);
    }
    public function things(){
        return $this->hasMany(Thing::class);
    }
}
