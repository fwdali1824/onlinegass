<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatNotificationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $userId;

    public function __construct($message, $userId)
    {
        $this->message = $message;
        $this->userId = $userId;
    }

    public function broadcastOn()
    {
        // Channel name where the event is broadcasted (can be private or public channel)
        return new Channel('chat.' . $this->userId);
    }

    public function broadcastAs()
    {
        // Event name
        return 'ChatNotification';
    }
}
