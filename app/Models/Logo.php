<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logo extends Model
{
    use HasFactory, HasSlug;

    protected $table      = 'logos';
    protected $primaryKey = 'id';

    protected string $slugType   = 'logo';
    protected string $slugField  = 'name';
    protected string $slugPrefix = '/logo';

    protected $fillable = [
        'name', 'price', 'ck', 'image', 'description', 'status',
    ];

    public static function getLogo($id, $row)
    {
        $logo = self::find($id);
        return $logo ? $logo->$row : null;
    }
}
