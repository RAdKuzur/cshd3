<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/** @property int $id
 * @property  int $user_id
 * @property int $rule_id
 *
 * @property User $user
 * @property Rule $rule
 *
 * */
class Permission extends Model
{
    protected $table = 'permissions';
    protected $fillable = [
        'user_id',
        'rule_id'
    ];
    public function user(){
        return $this->belongsTo(USer::class);
    }
    public function rule(){
        return $this->belongsTo(Rule::class);
    }
}
