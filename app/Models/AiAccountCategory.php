<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiAccountCategory extends Model
{
    use HasFactory;

    protected $table = 'ai_accounts_categories';

    protected $fillable = [
        'account_id',
        'varian_name',
        'price',
        'old_price',
        'stock_quantity',
        'duration_days',
        'sku'
    ];
}
