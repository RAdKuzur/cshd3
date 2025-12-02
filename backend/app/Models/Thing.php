<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Thing extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'serial_number',
        'inv_number',
        'operation_date',
        'thing_type_id',
        'thing_parent_id',
        'condition',
        'auditorium_id',
        'price',
        'comment',
    ];

    protected $casts = [
        'operation_date' => 'date',
        'condition' => 'integer',
        'price' => 'float',
    ];
    /**
     * Получить родительскую вещь
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Thing::class, 'thing_parent_id');
    }

    /**
     * Получить дочерние вещи
     */
    public function children(): HasMany
    {
        return $this->hasMany(Thing::class, 'thing_parent_id');
    }
    public function auditorium(): BelongsTo
    {
        return $this->belongsTo(Auditorium::class, 'auditorium_id');
    }
}
