<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Licenses extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'license_key',
        'domain',
        'status',
        'cmt',
        'expiry_date',
    ];
    protected $casts = [
        'domain' => 'array',
    ];
}
