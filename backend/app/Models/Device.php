<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/** @property int $id
 * @property int $model_id
 * @property int $thing_id
 *
 * @property \App\Models\Model $model
 * @property Thing $thing
*/
class Device extends Model
{
    protected $table = 'devices';
    protected $fillable = [
        'model_id',
        'thing_id'
    ];
    public function model()
    {
        return $this->belongsTo(Model::class);
    }
    public function thing()
    {
        return $this->belongsTo(Thing::class);
    }
}
