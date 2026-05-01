<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HostingPackages extends Model
{
  use HasFactory;
  
  protected $table = 'tbl_hosting_packages';
  protected $primaryKey = 'id';
  protected $fillable = [
    'category',
    'package_name',
    'disk_quota',
    'bandwidth_limit',
    'max_subdomains',
    'max_parked_domains',
    'max_addon_domains',
    'language',
    'cpanel_module',
    'status',
    'price',
    'description',
  ];
}
