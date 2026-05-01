<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiLogo extends Model
{
  use HasFactory;
  
  protected $table = 'api_logo';
  protected $primaryKey = 'id';
  protected $fillable = [
    'shortName',
    'logo',
    'name',
  ];
  public static function GetApiBank($code, $row, $name)
  {
    $api = self::where($row, $code)->first();
      return $api ? $api->$name : null;
  }
}
