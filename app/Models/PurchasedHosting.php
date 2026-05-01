<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchasedHosting extends Model
{
  use HasFactory;
  
  protected $table = 'tbl_purchased_hosting';
  protected $primaryKey = 'id';
  protected $fillable = [
    'user_id',
    'package_id',
    'ip',
    'block_ip',
    'start_date',
    'end_date',
    'username',
    'password',
    'email',
    'domain_name',
    'server_whm',
    'info_package',
    'price',
    'month',
    'total',
    'status',
    'giahan',
  ];
  protected $casts = [
    'server_whm' => 'array',
    'info_package' => 'array'
  ];
  public function setContentAttribute($value)
  {
      $this->attributes['server_whm'] = json_encode($value);
      $this->attributes['info_package'] = json_encode($value);
  }
}
