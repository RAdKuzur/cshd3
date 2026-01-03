<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/** @property int $id
 * @property int $people_position_id
 * @property int $transfer_act_id
 * @property int $status
 *
 * @property PeoplePosition $peoplePosition
 * @property TransferAct $transferAct
*/
class TransferActConfirm extends Model
{
    protected $table = 'transfer_act_confirms';

    protected $fillable = [
        'transfer_act_id',
        'people_position_id',
        'status'
    ];
    public function transferAct(){
        return $this->belongsTo(TransferAct::class);
    }
    public function peoplePosition(){
        return $this->belongsTo(PeoplePosition::class);
    }
}
