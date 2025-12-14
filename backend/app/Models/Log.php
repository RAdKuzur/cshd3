<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/** @property int $id
 * @property int $user_id
 * @property string $table
 * @property int $type
 * @property string $bindings
 * @property string $extra_bindings
 *
 * $property $time
 * @property User $user
 */
class Log extends Model
{
    protected $table = 'logs';

    public const SELECT = 1;
    public const INSERT = 2;
    public const UPDATE = 3;
    public const DELETE = 4;

    protected $fillable = [
        'user_id',
        'table',
        'type',
        'bindings',
        'extra_bindings',
        'time'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }

}
