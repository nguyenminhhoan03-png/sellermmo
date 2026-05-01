<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class PaymentSucceeded implements ShouldBroadcast
{
    use SerializesModels;

    public $message;
    public $channelName;

    public function __construct($message, $channelName)
    {
        $this->message = $message;
        $this->channelName = $channelName;
    }

    public function broadcastOn()
    {
        return new Channel($this->channelName);
    }

    public function broadcastAs()
    {
        return 'realtime';
    }
}



