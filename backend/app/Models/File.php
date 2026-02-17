<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * @property integer $id
 * @property string $table_name
 * @property integer $row_id
 * @property string $file_id
 * @property string $filename
 */
class File extends Model
{
    protected $table = 'files';

    public const BASE_URL = '/storage/app/public/uploads/';

    protected $fillable = [
        'table_name',
        'row_id',
        'file_id',
        'filename',
    ];
}
