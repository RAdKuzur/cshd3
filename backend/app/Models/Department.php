<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/** @property  int $id
 * @property string $name
 * @property int $organization_id
 * @property string $address
 *
 * @property Organization $organization
 * @property Auditorium[] $auditoriums
 * */
class Department extends Model
{
    protected $table = 'departments';
    protected $fillable = [
        'name',
        'organization_id',
        'address'
    ];
    public function organization(){
        return $this->belongsTo(Organization::class);
    }
    public function auditoriums(){
        return $this->hasMany(Auditorium::class);
    }
}
