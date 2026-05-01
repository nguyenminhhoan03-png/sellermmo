<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
  use HasFactory;

  protected $fillable = [
    'id',
    'user_id',
    'category_id',
    'title',
    'mota',
    'image',
    'slug',
    'content',
    'status',
    'view',
  ];

  protected $casts = [
    'status'    => 'boolean',
  ];

  public static function generateSlug($title)
  {
    $slug = str()->slug($title);

    if (self::where('slug', $slug)->exists()) {
      $slug .= '-' . rand(1000, 9999);
    }

    return $slug;
  }
  public static function Get_total($id)
    {
      $total = self::where('category_id', $id)->count();
        return $total ? $total : 0;
    }

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  public function category(): BelongsTo
  {
    return $this->belongsTo(PostCategory::class, 'category_id');
  }

}
