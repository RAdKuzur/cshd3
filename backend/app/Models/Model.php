<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
/**
* @property int $id
* @property int $company_id
* @property string $name
*
* @property Company $company
* @property Device[] $devices
* @property ModelResource[] $modelResources
*/
class Model extends EloquentModel
{
    protected $table = 'models';
    protected $fillable = [
        'company_id',
        'name'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function devices()
    {
        return $this->hasMany(Device::class);
    }
    public function modelResources()
    {
        return $this->hasMany(ModelResource::class);
    }
}
