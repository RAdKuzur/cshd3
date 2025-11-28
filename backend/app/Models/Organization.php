<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/** @property int $id
 * @property string $name
 * @property string|null $address
 * @property string|null $inn
 * @property string|null $ogrn
 *
 * @property People[] $people
 * @property Department[] $departments
 * @property Branch[] $branches
 */
class Organization extends Model
{
    protected $table = 'organizations';
    protected $fillable = [
        'name',
        'address',
        'inn',
        'ogrn'
    ];
    protected $hidden = [

    ];
    public function people(){
        return $this->hasMany(People::class);
    }

    public function departments(){
        return $this->hasMany(Department::class);
    }
    public function branches(){
        return $this->hasMany(Branch::class);
    }
}
