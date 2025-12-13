<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/** @property int $id
 * @property int $user_id
 * @property string $query
 * $property $time

 * @property User $user
 */
class Log extends Model
{
    protected $table = 'logs';
    protected $fillable = [
        'user_id',
        'query',
        'time'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }

}
