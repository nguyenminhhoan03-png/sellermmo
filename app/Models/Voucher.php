<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
  use HasFactory;

  protected $fillable = [
    'id',
    'code',
    'type',
    'qty',
    'value',
    'username',
    'start_date',
    'expire_date'
  ];

  protected $casts = [
    'value'       => 'integer',
    'start_date'  => 'date',
    'expire_date' => 'date',
  ];
}
