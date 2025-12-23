<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** @property int $id
 * @property int $thing_id
 * @property int $auditorium_id
 * @property $start_date
 * @property $end_date
 *
 * @property Thing $thing
 * @property Auditorium $auditorium
 */
class ThingAuditorium extends Model
{
    protected $table = 'thing_auditoriums';
    protected $fillable = [
        'thing_id',
        'auditorium_id',
        'start_date',
        'end_date'
    ];
    public function thing() {
        return $this->belongsTo(Thing::class);
    }
    public function auditorium(){
        return $this->belongsTo(Auditorium::class);
    }
}
