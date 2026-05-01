<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
  use HasFactory;

  protected $fillable = [
    'code',
    'amount',
    'real_amount',
    'balance_after',
    'balance_before',
    'type',
    'extras',
    'order_id',
    'sys_note',
    'status',
    'lickey',
    'content',
    'user_id',
    'username',
  ];

  protected $hidden = [
    'order_id',
    'sys_note',
    'extras',
  ];

  protected $appends = [
    'prefix',
  ];

  protected $casts = [
    'extras' => 'array',
  ];

  public function getPrefixAttribute()
  {
    return $this->balance_before > $this->balance_after ? '-' : '+';
  }
  public static function Getpay($code, $row)
  {
    $transaction = self::where('code', $code)->first();
      return $transaction ? $transaction->$row : null;
  }
}
