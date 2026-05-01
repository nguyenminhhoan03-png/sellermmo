<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $fillable = [
        'username', 'chat_id', 'name', 'password', 'email', 'level', 'access_token', 'ip',
        'device', 'otp', 'balance', 'balance_ctv', 'total_deposit', 'banned', 'loai', 'gioi_thieu', 'skill', 'time_request',
        'created_at', 'updated_at'
    ];

    protected $hidden = [
        'password', 'access_token'
    ];
     public function transactions()
    {
    return $this->hasMany(Transaction::class);
   }
   public function histories()
  {
    return $this->hasMany(Logs::class);
  }
   public static function getUser($id, $row)
   {
       $user = self::find($id);
       return $user ? $user->$row : null;
   }
   public static function update_time_request($id, $time) {
       $user = self::find($id);
       $user->time_request = $time;
       $user->save();
   }
}
