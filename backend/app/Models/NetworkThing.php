<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** @property int $id
 * @property int $thing_id
 * @property string $ip_address
 * @property string $domain
 * @property string $phone_number
 * @property string $comment
 *
 * @property Thing $thing
 */
class NetworkThing extends Model
{
    protected $table = 'network_things';

    protected $fillable = [
        'thing_id',
        'ip_address',
        'domain',
        'phone_number',
        'comment'
    ];

    public function thing()
    {
        return $this->belongsTo(Thing::class);
    }
}
