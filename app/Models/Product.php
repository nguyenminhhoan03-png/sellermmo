<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, HasSlug;

    protected $table        = 'tbl_list_code';
    protected $primaryKey   = 'id';
    public    $timestamps   = true;

    /** @var string slug_type ghi vào bảng slugs */
    protected string $slugType   = 'code';
    /** @var string Cột dùng để sinh slug */
    protected string $slugField  = 'name';
    /** @var string Prefix URL hiển thị ngoài trình duyệt */
    protected string $slugPrefix = '/view';

    protected $fillable = [
        'name', 'user_id', 'price', 'images', 'list_images',
        'intro', 'view', 'sold', 'link_down', 'link_demo',
        'status', 'ck', 'category', 'created_at', 'updated_at',
    ];

    public const CATEGORIES = [
        'website'   => ['label' => 'Website',    'icon' => '🌐'],
        'game'      => ['label' => 'Game',        'icon' => '🎮'],
        'phanmem'   => ['label' => 'Phần mềm',   'icon' => '💻'],
        'ecommerce' => ['label' => 'E-commerce',  'icon' => '🛒'],
        'blog'      => ['label' => 'Blog/News',   'icon' => '📰'],
        'account'   => ['label' => 'Tài khoản',   'icon' => '🔑'],
        'mail'      => ['label' => 'Email (Gmail...)', 'icon' => '📧'],
        'via_bm'    => ['label' => 'Via & BM FB', 'icon' => '📘'],
        'clone'     => ['label' => 'Clone / MXH', 'icon' => '👥'],
        'vps'       => ['label' => 'VPS / Hosting', 'icon' => '🖥️'],
        'tool'      => ['label' => 'Tool / Bot', 'icon' => '🛠️'],
        'other'     => ['label' => 'Khác',        'icon' => '📦'],
    ];

    public static function getCode($id, $row)
    {
        $product = self::find($id);
        return $product ? $product->$row : null;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }
}
