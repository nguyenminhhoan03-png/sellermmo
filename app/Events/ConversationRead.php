<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ConversationRead implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $conversationId;
    public string $readerType;

    public function __construct(int $conversationId, string $readerType)
    {
        $this->conversationId = $conversationId;
        $this->readerType = $readerType;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('admin-chat-channel'),
            new Channel('client-chat-channel-' . $this->conversationId),
        ];
    }

    public function broadcastAs(): string
    {
        return 'conversation-read';
    }

    public function broadcastWith(): array
    {
        return [
            'conversationId' => $this->conversationId,
            'readerType' => $this->readerType,
        ];
    }
}
