<?php 

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
  protected $primaryKey = 'id';
    protected $fillable = ['post_id', 'content'];
  
    protected $casts = [
        'content' => 'array',
    ];
    public function setContentAttribute($value)
    {
        $this->attributes['content'] = json_encode($value);
    }
}
