<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $table = 'tbl_product_variants';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'product_id',
        'name',
        'price',
        'old_price',
        'created_at',
        'updated_at'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function accounts()
    {
        return $this->hasMany(ProductAccount::class, 'variant_id');
    }
}
