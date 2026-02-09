<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/** @property int $id
 * @property string $name
 * @property int $type
 * @property int $amount
 *
 * @property ModelResource[] $modelResources
*/

class Resource extends Model
{
    protected $table = 'resources';
    protected $fillable = [
        'name',
        'type',
        'amount'
    ];
    public function modelResources()
    {
        return $this->hasMany(ModelResource::class);
    }
}
