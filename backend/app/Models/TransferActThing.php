<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/** @property int $id
 * @property int $transfer_act_id
 * @property int $thing_id
 *
 * @property TransferAct $transferAct
 * @property Thing $thing
*/
class TransferActThing extends Model
{
    protected $table = 'transfer_act_things';

    protected $fillable = [
        'transfer_act_id',
        'thing_id',
    ];
    public function thing(){
        return $this->belongsTo(Thing::class);
    }
    public function transfer_act(){
        return $this->belongsTo(TransferAct::class);
    }

}
