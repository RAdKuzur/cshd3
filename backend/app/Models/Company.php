<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * @property int $id
 * @property string $name
 *
 * @property \App\Models\Model[] $models
 */
class Company extends Model
{
    protected $table = 'companies';
    protected $fillable = [
        'name'
    ];
    public function models()
    {
        return $this->hasMany(Model::class);
    }
}
