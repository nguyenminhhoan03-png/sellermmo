<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhmInfo extends Model
{
  use HasFactory;
  
  protected $table = 'tbl_whm_info';
  protected $primaryKey = 'id';
  protected $fillable = [
    'category',
    'whm_host',
    'ip',
    'whm_user',
    'whm_pass',
    'accesshash',
    'status',
  ];
}
