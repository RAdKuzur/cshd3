<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/** @property int $id
 * @property int $from
 * @property int $to
 * @property $time
 * @property int $confirmed
 * @property int $type
 *
 * @property People $fromPerson
 * @property People $toPerson
 * @property TransferActThing[] $transferActThings
*/
class TransferAct extends Model
{
    protected $table = 'transfer_acts';
    protected $fillable = [
        'from',
        'to',
        'time',
        'confirmed',
        'type'
    ];

    public function fromPerson()
    {
        return $this->belongsTo(People::class, 'from');
    }
    public function toPerson(){
        return $this->belongsTo(People::class, 'to');
    }
    public function transferActThings(){
        return $this->hasMany(TransferActThing::class, 'transfer_act_id');
    }
}
