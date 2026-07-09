<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAccount extends Model
{
    use HasFactory;

    protected $table = 'tbl_product_accounts';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'product_id',
        'variant_id',
        'account_info',
        'buyer_id',
        'trans_id',
        'status',
        'created_at',
        'updated_at'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
}
