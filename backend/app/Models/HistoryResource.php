<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/** @property int $id
 * @property int $resource_id
 * @property int $amount
 *
 * @property Resource $resource
 * */
class HistoryResource extends Model
{
    protected $table = 'history_resources';

    protected $fillable = [
        'resource_id',
        'amount'
    ];

    public function resource(){
        return $this->belongsTo(Resource::class);
    }
}
