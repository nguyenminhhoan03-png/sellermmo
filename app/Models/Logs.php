<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    use HasFactory;

    protected $table = 'logs';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'action',
        'data',
        'old_data',
        'new_data',
        'ip',
        'description',
        'data_json',
    ];
}
