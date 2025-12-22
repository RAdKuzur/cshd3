<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/** @property int $id
 * @property  int $role
 * @property int $rule_id
 *
 * @property Rule $rule
 *
 * */
class Permission extends Model
{
    protected $table = 'permissions';
    protected $fillable = [
        'role',
        'rule_id'
    ];
    public function rule(){
        return $this->belongsTo(Rule::class);
    }
}
