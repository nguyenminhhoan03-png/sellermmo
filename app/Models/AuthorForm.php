<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'team',
        'team_members',
        'other_account',
        'market_account',
        'work_category',
        'status',
    ];

    protected $casts = [
        'work_category' => 'array',
    ];
}
