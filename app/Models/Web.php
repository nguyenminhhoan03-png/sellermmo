<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Web extends Model
{
    use HasFactory, HasSlug;

    protected $table      = 'web';
    protected $primaryKey = 'id';

    protected string $slugType   = 'web';
    protected string $slugField  = 'name';
    protected string $slugPrefix = '/web';

    protected $fillable = [
        'user_id', 'name', 'price', 'ck', 'images',
        'description', 'status', 'list_images', 'extend',
    ];

    public static function getWeb($id, $row)
    {
        $web = self::find($id);
        return $web ? $web->$row : null;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
