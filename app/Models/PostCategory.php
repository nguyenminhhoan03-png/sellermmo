<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PostCategory extends Model
{
    use HasFactory;

    protected $table = 'post_category';

    protected $primaryKey = 'id';

    public $timestamps = true;
    protected $fillable = [
        'id',
        'name',
        'slug',
        'status',
        'created_at',
        'updated_at'
    ];
    public static function generateSlug($title)
  {
    $slug = str()->slug($title);

    if (self::where('slug', $slug)->exists()) {
      $slug .= '-' . rand(1000, 9999);
    }

    return $slug;
  }
  public static function getCategory($id, $row)
    {
        $category = self::find($id);
        return $category ? $category->$row : null;
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'category_id');
    }
    
}
