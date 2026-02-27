<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * @property int $id
 * @property string $message
 * @property string $trace
 * @property $time
 */
class ErrorLog extends Model
{
    protected $table = 'error_logs';
    protected $fillable = [
        'message',
        'trace',
        'time'
    ];
}
