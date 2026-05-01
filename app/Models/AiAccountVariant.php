<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiAccountVariant extends Model
{
    use HasFactory;

    protected $table = 'ai_accounts_variant';

    protected $fillable = [
        'account_id',
        'variant_name',
        'price',
        'old_price',
        'stock_quantity',
        'duration_days',
        'sku',
    ];
}
