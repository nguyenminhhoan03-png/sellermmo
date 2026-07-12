<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiAccountOrder extends Model
{
    use HasFactory;

    protected $table = 'ai_accounts_order';

    protected $fillable = [
        'user_id',
        'ai_account_id',
        'seller_id',
        'variant_id',
        'trans_id',
        'price',
        'status',
        'note',
        'expiry_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function aiAccount()
    {
        return $this->belongsTo(AiAccount::class, 'ai_account_id');
    }

    public function variant()
    {
        return $this->belongsTo(AiAccountVariant::class, 'variant_id');
    }

    /**
     * Người bán (snapshot tại thời điểm mua).
     * null = admin quản lý.
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}
