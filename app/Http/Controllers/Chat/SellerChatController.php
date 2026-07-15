<?php

declare(strict_types=1);

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Models\ChatConversation;
use App\Models\ChatMessage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerChatController extends Controller
{
    // ─── User gửi tin nhắn đến Seller ──────────────────────────────────────────

    /**
     * User gửi tin → tìm/tạo conversation user↔seller rồi lưu tin nhắn.
     */
    public function sendToSeller(Request $request)
    {
        $request->validate([
            'seller_id' => 'required|integer|exists:users,id',
            'message'   => 'required|string|max:2000',
            'order_ref' => 'nullable|string|max:100',
        ]);

        $userId   = Auth::id();
        $sellerId = (int) $request->seller_id;
        $content  = trim($request->message);
        $orderRef = $request->order_ref;

        // Tìm conversation user↔seller (nếu có order_ref thì match theo luôn)
        $conversation = ChatConversation::where('user_id', $userId)
            ->where('seller_id', $sellerId)
            ->when($orderRef, fn($q) => $q->where('order_ref', $orderRef))
            ->first();

        if (!$conversation) {
            $conversation = ChatConversation::create([
                'user_id'        => $userId,
                'seller_id'      => $sellerId,
                'order_ref'      => $orderRef,
                'last_message'   => $content,
                'last_message_at'=> Carbon::now(),
                'unread_seller'  => 1,
                'unread_admin'   => 0,
                'unread_user'    => 0,
            ]);
        } else {
            $conversation->update([
                'last_message'   => $content,
                'last_message_at'=> Carbon::now(),
                'unread_seller'  => $conversation->unread_seller + 1,
            ]);
        }

        $message = ChatMessage::create([
            'conversation_id' => $conversation->id,
            'sender_type'     => 'user',
            'sender_id'       => $userId,
            'content'         => $content,
            'type'            => 'text',
        ]);

        // Bắn Pusher event để Seller nhận real-time
        try {
            broadcast(new \App\Events\MessageSent($message, $conversation->id))->toOthers();
        } catch (\Exception $e) {
            // Pusher không bắt buộc
        }

        return response()->json([
            'status'  => 200,
            'time'    => $message->created_at->format('H:i'),
        ]);
    }

    /**
     * User lấy lịch sử tin nhắn với seller.
     */
    public function getMessages(Request $request, int $seller_id)
    {
        $userId = Auth::id();
        $orderRef = $request->query('order_ref');

        $conversation = ChatConversation::where('user_id', $userId)
            ->where('seller_id', $seller_id)
            ->when($orderRef, fn($q) => $q->where('order_ref', $orderRef))
            ->first();

        if (!$conversation) {
            return response()->json(['messages' => [], 'conversation_id' => null]);
        }

        // Đánh dấu user đã đọc
        if ($conversation->unread_user > 0) {
            $conversation->update(['unread_user' => 0]);
            ChatMessage::where('conversation_id', $conversation->id)
                ->where('sender_type', 'seller')
                ->where('is_read', 0)
                ->update(['is_read' => 1]);
        }

        $messages = ChatMessage::where('conversation_id', $conversation->id)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'messages'        => $messages,
            'conversation_id' => $conversation->id,
        ]);
    }

    // ─── Seller: Inbox (danh sách hội thoại) ────────────────────────────────────

    public function inbox(Request $request)
    {
        $sellerId = Auth::id();

        $conversations = ChatConversation::with('user')
            ->where('seller_id', $sellerId)
            ->orderBy('last_message_at', 'desc')
            ->get();

        $totalUnread = $conversations->sum('unread_seller');

        $activeId           = (int) $request->query('room', $conversations->first()?->id ?? 0);
        $activeConversation = $conversations->firstWhere('id', $activeId) ?? $conversations->first();
        $messages           = collect();

        if ($activeConversation) {
            // Đánh dấu đã đọc
            if ($activeConversation->unread_seller > 0) {
                $unreadBefore = (int) $activeConversation->unread_seller;
                $activeConversation->update(['unread_seller' => 0]);
                $activeConversation->unread_seller = 0;
                $totalUnread = max(0, $totalUnread - $unreadBefore);

                ChatMessage::where('conversation_id', $activeConversation->id)
                    ->where('sender_type', 'user')
                    ->where('is_read', 0)
                    ->update(['is_read' => 1]);
            }

            $messages = ChatMessage::where('conversation_id', $activeConversation->id)
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return view('seller.chat.inbox', compact(
            'conversations',
            'activeConversation',
            'messages',
            'totalUnread',
        ));
    }

    /**
     * Seller trả lời tin nhắn.
     */
    public function reply(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|integer',
            'message'         => 'required|string|max:2000',
        ]);

        $sellerId = Auth::id();
        $conversation = ChatConversation::where('id', $request->conversation_id)
            ->where('seller_id', $sellerId)
            ->firstOrFail();

        $message = ChatMessage::create([
            'conversation_id' => $conversation->id,
            'sender_type'     => 'seller',
            'sender_id'       => $sellerId,
            'content'         => $request->message,
            'type'            => 'text',
        ]);

        $conversation->update([
            'last_message'    => $request->message,
            'last_message_at' => Carbon::now(),
            'unread_user'     => $conversation->unread_user + 1,
        ]);

        try {
            broadcast(new \App\Events\MessageSent($message, $conversation->id))->toOthers();
        } catch (\Exception $e) {
            //
        }

        return response()->json([
            'status' => 'success',
            'time'   => $message->created_at->format('H:i'),
        ]);
    }

    /**
     * Lấy messages của 1 conversation (cho polling/AJAX của seller).
     */
    public function getConversation(int $conversation_id)
    {
        $sellerId = Auth::id();

        $conversation = ChatConversation::where('id', $conversation_id)
            ->where('seller_id', $sellerId)
            ->firstOrFail();

        if ($conversation->unread_seller > 0) {
            $conversation->update(['unread_seller' => 0]);
            ChatMessage::where('conversation_id', $conversation_id)
                ->where('sender_type', 'user')
                ->where('is_read', 0)
                ->update(['is_read' => 1]);
        }

        $messages = ChatMessage::where('conversation_id', $conversation_id)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'messages'        => $messages,
            'conversation_id' => $conversation_id,
        ]);
    }
}
