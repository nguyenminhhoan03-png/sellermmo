<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Createweb extends Model
{
    use HasFactory;
  
    protected $table = 'createwebs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'trans_id',
        'user_id',
        'web_id',
        'tk',
        'mk',
        'domain',
        'pointer',
        'time_exp',
        'price',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    public function web()
    {
        return $this->belongsTo(Web::class, 'web_id', 'id');
    }
}
