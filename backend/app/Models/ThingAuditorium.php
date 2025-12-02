<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ThingAuditorium extends Model
{
    use HasFactory;

    protected $table = 'thing_auditoriums';

    protected $fillable = [
        'thing_id',
        'auditorium_id',
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
     * Получить аудиторию
     */
    public function auditorium(): BelongsTo
    {
        return $this->belongsTo(Auditorium::class);
    }
}
