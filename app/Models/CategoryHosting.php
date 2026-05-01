<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryHosting extends Model
{
  use HasFactory;
  
  protected $table = 'tbl_category_hosting';
  protected $primaryKey = 'id';
  protected $fillable = [
    'name',
    'logo',
    'anh',
    'status',
  ];
}
