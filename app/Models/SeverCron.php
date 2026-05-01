<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeverCron extends Model
{
  use HasFactory;
  protected $table = 'sever_crons';
  protected $fillable = [
    'name',
    'price',
    'ck',
    'quantity',
    'limit_second',
    'status'
  ];
}
