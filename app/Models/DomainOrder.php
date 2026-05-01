<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DomainOrder extends Model
{
    use HasFactory;

    protected $table = 'domain_order';

    protected $primaryKey = 'id';

    public $timestamps = true;
    protected $fillable = [
        'trans_id',
        'user_id',
        'domain_name',
        'ns',
        'price',
        'time_han',
        'expired_date',
        'expired_timestamp',
        'giahan',
        'status',
        'created_at',
        'updated_at'
    ];
}
