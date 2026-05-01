<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherLog extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'code',
    'value',
    'created_at',
    'updated_at',
  ];
}
