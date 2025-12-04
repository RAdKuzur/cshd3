<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/** @property int $id
 * @property int $auditorium_id
 * @property int $people_id
 * @property \Illuminate\Support\Carbon $start_date
 * @property boolean $is_active
 *
 * @property Auditorium $auditorium
 * @property People $people
*/
class AuditoriumResponsibility extends Model
{
    protected $table = 'auditorium_responsibilities';
    protected $fillable = [
        'auditorium_id',
        'people_id',
        'start_date',
        'end_date'
    ];
    public function auditorium(){
        return $this->belongsTo(Auditorium::class);
    }
    public function people(){
        return $this->belongsTo(People::class);
    }
}
