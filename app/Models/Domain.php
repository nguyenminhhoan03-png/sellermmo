<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use HasFactory;

    protected $table = 'domain';

    protected $primaryKey = 'id';

    public $timestamps = true;
    protected $fillable = [
        'name',
        'price',
        'extend_price',
        'status',
        'sale',
        'created_at',
        'updated_at'
    ];
    public static function Getextend($code, $row)
  {
    $domainmoney = self::where('name', $code)->first();
      return $domainmoney ? $domainmoney->$row : null;
  }
  public static function Getmoney($code, $row)
  {
    $domainmoney = self::where('name', $code)->first();
    $sale = ($domainmoney->price * (1 - $domainmoney->sale / 100));
      return $sale ? $sale : null;
  }
}
