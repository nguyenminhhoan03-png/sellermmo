<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hisproduct extends Model
{
    use HasFactory;

    protected $table = 'tbl_his_code';

    protected $primaryKey = 'id';

    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'product_id',
        'trans_id',
        'price',
        'created_at',
        'updated_at'
    ];
}
