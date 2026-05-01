<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hislogo extends Model
{
    use HasFactory;

    protected $table = 'his_logo';

    protected $primaryKey = 'id';

    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'logo_id',
        'trans_id',
        'price',
        'name',
        'link',
        'status',
    ];
}
