<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/** @property int $id
 * @property int $user_id
 * @property int $type
 * @property string $message
 * @property int $is_read
 *
 * @property User $user
*/
class Notification extends Model
{

    public const UNREAD = 1;
    public const READ = 2;

    protected $table = 'notifications';

    protected $fillable = [
        'user_id',
        'type',
        'message',
        'is_read'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
