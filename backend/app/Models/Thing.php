<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/** @property int $id
 * @property string $name
 * @property string $serial_number
 * @property string $inv_number
 * @property $operation_date
 * @property int $thing_type_id
 * @property int $thing_parent_id
 * @property int $condition
 * @property int $balance
 * @property float $price
 * @property string $comment
 *
 * @property ThingResponsibility[] $thingResponsibilities
 * @property ThingAuditorium[] $thingAuditoriums
 * @property TransferActThing[] $transferActThings
*/



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
        'balance',
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
    public function getActualMaster(){
        return $this->thingResponsibilities()->where([
            'end_date' => null,
        ])->first() ? $this->thingResponsibilities()->where([
            'end_date' => null,
        ])->first()->people : null;
    }
    public function getCurrentLocation(){
        return $this->thingAuditoriums()->where([
            'end_date' => null,
        ])->first()->auditorium;
    }
    /**
     * Получить дочерние вещи
     */
    public function children(): HasMany
    {
        return $this->hasMany(Thing::class, 'thing_parent_id');
    }
    public function thingAuditoriums(){
        return $this->hasMany(ThingAuditorium::class);
    }
    public function thingResponsibilities(){
        return $this->hasMany(ThingResponsibility::class);
    }
    public function transferActThings(){
        return $this->hasMany(TransferActThing::class);
    }
}
