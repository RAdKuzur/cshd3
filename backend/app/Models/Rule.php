<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $path
 * @property Permission[] $permissions
 * */

class Rule extends Model
{
    protected $table = 'rules';
    protected $fillable = [
        'name',
        'path'
    ];
    protected $hidden = [];
    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }

}
