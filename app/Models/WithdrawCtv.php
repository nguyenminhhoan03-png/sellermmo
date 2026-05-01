<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawCtv extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'trans_id',
    'price',
    'bank',
    'stk',
    'ctk',
    'status',
    'url',
    'message'
  ];

  protected $casts = [
    'value' => 'array',
  ];
}
