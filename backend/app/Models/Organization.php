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
}
