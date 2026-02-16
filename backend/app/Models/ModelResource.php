<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
/**
 * @property int $id
 * @property int $model_id
 * @property int $resource_id
 *
 * @property Model $model
 * @property Resource $resource
 */
class ModelResource extends EloquentModel
{
    protected $table = 'model_resources';

    protected $fillable = [
        'model_id',
        'resource_id',
    ];

    public function model() {
        return $this->belongsTo(Model::class);
    }
    public function resource() {
        return $this->belongsTo(Resource::class);
    }
}
