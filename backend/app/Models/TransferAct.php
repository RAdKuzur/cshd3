<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/** @property int $id
 * @property int $from
 * @property int $to
 * @property $date
 * @property int $confirmed
 * @property int $type
 *
 * @property PeoplePosition $fromPerson
 * @property PeoplePosition $toPerson
 * @property TransferActThing[] $transferActThings
 * @property TransferActConfirm[] $transferActConfirms
*/
class TransferAct extends Model
{
    protected $table = 'transfer_acts';
    protected $fillable = [
        'from',
        'to',
        'date',
        'confirmed',
        'type'
    ];

    public function fromPerson()
    {
        return $this->belongsTo(PeoplePosition::class, 'from');
    }
    public function toPerson(){
        return $this->belongsTo(PeoplePosition::class, 'to');
    }
    public function transferActThings(){
        return $this->hasMany(TransferActThing::class, 'transfer_act_id');
    }
    public function transferActConfirms(){
        return $this->hasMany(TransferActConfirm::class, 'transfer_act_id');
    }
}
