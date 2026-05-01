<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CronOrder extends Model
{
    use HasFactory;

    protected $table = 'list_url_cron';

    protected $primaryKey = 'id';

    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'id_server',
        'trans_id',
        'url',
        'price',
        'second',
        'status',
        'response',
        'time_his',
        'expired_date',
        'expired_timestamp',
    ];
    public static function Get_total($id)
    {
      $total = self::where('id_server', $id)->count();
        return $total ? $total : 0;
    }
}
