<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatConversation extends Model
{
    use HasFactory;

    protected $table = 'chat_conversations';
    
    // Khai báo cho phép insert tất cả các cột
    protected $guarded = [];

    // Tự động format kiểu thời gian cho các trường
    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    /**
     * Mối quan hệ: Một đoạn chat thuộc về một User (Khách hàng)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Mối quan hệ: Một đoạn chat chứa nhiều tin nhắn
     */
    public function messages()
    {
        return $this->hasMany(ChatMessage::class, 'conversation_id', 'id');
    }
}
