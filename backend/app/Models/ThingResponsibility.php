<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
/** @property int $id
 * @property int $thing_id
 * @property int $people_id
 * @property $start_date
 * @property $end_date
 *
 * @property Thing $thing
 * @property People $people
*/

class ThingResponsibility extends Model
{
    use HasFactory;

    protected $table = 'thing_responsibilities';

    protected $fillable = [
        'thing_id',
        'people_id',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Получить вещь
     */
    public function thing(): BelongsTo
    {
        return $this->belongsTo(Thing::class);
    }

    /**
     * Получить ответственное лицо
     */
    public function people(): BelongsTo
    {
        return $this->belongsTo(People::class, 'people_id');
    }
}
