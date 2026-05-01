<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $table = 'chat_messages';

    // Khai báo cho phép insert tất cả các cột
    protected $guarded = [];

    // Format boolean cho cờ trạng thái đọc
    protected $casts = [
        'is_read' => 'boolean',
    ];

    /**
     * Mối quan hệ: Một tin nhắn luôn thuộc về một hộp thoại (Conversation)
     */
    public function conversation()
    {
        return $this->belongsTo(ChatConversation::class, 'conversation_id', 'id');
    }

    /**
     * Mối quan hệ: Lấy về người gửi tin (Phần này có thể gọi ra nếu bạn cần lấy Tên/Avatar của khách)
     */
    public function sender()
    {
        // Trả về User model với điều kiện là sender_type = 'user'
        // Nếu là admin thì bạn có thể thiết kế mảng relationships khác tùy logic
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }
}
