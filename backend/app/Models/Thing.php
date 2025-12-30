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
 * @property bool $is_composite
 * @property Thing[] $children
 *
 *
 * @property ThingAuditorium[] $thingAuditoriums
 * @property TransferActThing[] $transferActThings
*/


class Thing extends Model
{
    use HasFactory;
    protected $table = 'things';
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
        'is_composite',
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
    public function getActualMaster() : ?People
    {
        return $this->transferActThings()
            ->join('transfer_acts', 'transfer_act_things.transfer_act_id', '=', 'transfer_acts.id')
            ->orderBy('transfer_acts.date', 'desc')
            ->first()
            ?->transferAct
            ?->toPerson ;
    }
    public function getCurrentLocation() : ?Auditorium {
        return $this->thingAuditoriums()->where([
            'end_date' => null,
        ])->first() ? $this->thingAuditoriums()->where([
                'end_date' => null,
            ])->first()->auditorium : null;
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
    public function transferActThings(){
        return $this->hasMany(TransferActThing::class);
    }
}
