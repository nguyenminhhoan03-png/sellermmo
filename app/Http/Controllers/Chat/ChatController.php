<?php

declare(strict_types=1);

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChatConversation;
use App\Models\ChatMessage;
use App\Events\MessageSent;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        // Load danh sách conversation kèm tổng tin chưa đọc cho admin
        $conversations = ChatConversation::with('user')
            ->orderBy('last_message_at', 'desc')
            ->get();

        $totalUnreadAdmin = (int) $conversations->sum(function ($conversation) {
            return (int) ($conversation->unread_admin ?? 0);
        });

        if ($conversations->isEmpty()) {
            return view('admin.chat.index', compact('conversations', 'totalUnreadAdmin'));
        }

        // Lấy room đang active
        $active_id = $request->get('room', $conversations->first()->id);
        $activeConversation = $conversations->where('id', $active_id)->first() ?? $conversations->first();

        // Đánh dấu admin đã đọc tin nhắn
        if ($activeConversation->unread_admin > 0) {
            $unreadBefore = (int) $activeConversation->unread_admin;
            $activeConversation->update(['unread_admin' => 0]);
            $activeConversation->unread_admin = 0;
            $totalUnreadAdmin = max(0, $totalUnreadAdmin - $unreadBefore);

            // Cập nhật tất cả tin nhắn của USER trong phòng này là đã xem
            ChatMessage::where('conversation_id', $activeConversation->id)
                ->where('sender_type', 'user')
                ->where('is_read', 0)
                ->update(['is_read' => 1]);

            // Bắn event báo cho Khách biết là Admin đã đọc
            broadcast(new \App\Events\ConversationRead($activeConversation->id, 'admin'))->toOthers();
        }

        $messages = ChatMessage::where('conversation_id', $activeConversation->id)->orderBy('created_at', 'asc')->get();

        return view('admin.chat.index', compact('conversations', 'activeConversation', 'messages', 'totalUnreadAdmin'));
    }

    public function sendMessage(Request $request)
    {
        $conversationId = $request->conversation_id;
        $content = $request->message;

        // Lưu tin nhắn
        $message = ChatMessage::create([
            'conversation_id' => $conversationId,
            'sender_type' => 'admin',
            'sender_id' => Auth::id() ?? 1,
            'content' => $content,
            'type' => 'text',
        ]);

        // Cập nhật conversation state
        $conversation = ChatConversation::find($conversationId);
        if ($conversation) {
            $conversation->update([
                'last_message' => $content,
                'last_message_at' => Carbon::now(),
                'unread_user' => $conversation->unread_user + 1,
            ]);
        }

        // Bắn Pusher event để Frontend user nhận được
        broadcast(new MessageSent($message, $conversationId))->toOthers();

        return response()->json([
            'status' => 'success',
            'message' => $content,
            'time' => $message->created_at->format('h:i A')
        ]);
    }

    public function sendClientMessage(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['redirect' => route('login')], 401);
        }

        $content = $request->message;
        $userId = Auth::id();

        // Tìm hội thoại: Ưu tiên tìm theo tài khoản đăng nhập trước
        $conversation = ChatConversation::where('user_id', $userId)->first();

        if (!$conversation) {
            $conversation = ChatConversation::create([
                'user_id' => $userId,
                'last_message' => $content,
                'last_message_at' => Carbon::now(),
                'unread_admin' => 1
            ]);
        } else {
            $conversation->update([
                'last_message' => $content,
                'last_message_at' => Carbon::now(),
                'unread_admin' => $conversation->unread_admin + 1,
            ]);
        }

        $conversationId = $conversation->id;

        // Lưu tin nhắn
        $message = ChatMessage::create([
            'conversation_id' => $conversationId,
            'sender_type' => 'user',
            'sender_id' => $userId,
            'content' => $content,
            'type' => 'text',
        ]);

        // Cập nhật event bắn sang admin
        broadcast(new MessageSent($message, $conversationId))->toOthers();

        return response()->json([
            'status' => 'success',
            'time' => $message->created_at->format('h:i A')
        ]);
    }

    public function getClientMessages()
    {
        if (!Auth::check()) {
            return response()->json(['redirect' => route('login')], 401);
        }

        $conversation = ChatConversation::where('user_id', Auth::id())->first();

        if (!$conversation) {
            return response()->json(['messages' => []]);
        }

        // Đánh dấu Khách đã đọc tin nhắn của Admin
        if ($conversation->unread_user > 0) {
            $conversation->update(['unread_user' => 0]);

            ChatMessage::where('conversation_id', $conversation->id)
                ->where('sender_type', 'admin')
                ->where('is_read', 0)
                ->update(['is_read' => 1]);

            // Bắn event báo cho Admin biết là Khách đã đọc
            broadcast(new \App\Events\ConversationRead($conversation->id, 'user'))->toOthers();
        }

        $messages = ChatMessage::where('conversation_id', $conversation->id)->orderBy('created_at', 'asc')->get();
        return response()->json([
            'messages' => $messages,
            'conversation_id' => $conversation->id
        ]);
    }

    public function markAsRead(Request $request)
    {
        $conversationId = $request->conversation_id;
        $readerType = $request->reader_type; // 'admin' hoặc 'user'

        $conversation = ChatConversation::find($conversationId);
        if (!$conversation) return response()->json(['status' => 'error']);

        if ($readerType === 'admin') {
            $conversation->update(['unread_admin' => 0]);
            ChatMessage::where('conversation_id', $conversationId)
                ->where('sender_type', 'user')
                ->where('is_read', 0)
                ->update(['is_read' => 1]);
        } else {
            $conversation->update(['unread_user' => 0]);
            ChatMessage::where('conversation_id', $conversationId)
                ->where('sender_type', 'admin')
                ->where('is_read', 0)
                ->update(['is_read' => 1]);
        }

        broadcast(new \App\Events\ConversationRead($conversationId, $readerType))->toOthers();

        return response()->json(['status' => 'success']);
    }
}
