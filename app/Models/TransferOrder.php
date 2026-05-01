<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferOrder extends Model
{
    use HasFactory;

    protected $table = 'transfer_order';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'trans_id',
        'bank',
        'noidung',
        'price',
        'content',
        'status',
        'transactionID',
    ];

    protected $casts = [
        'content' => 'array',
    ];

    public function setContentAttribute($value)
    {
        $this->attributes['content'] = json_encode($value);
    }
}

