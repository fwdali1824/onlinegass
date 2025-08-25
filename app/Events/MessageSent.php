<?php

namespace App\Events;

use App\Models\Chats;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $receiverId;

    public function __construct(Chats $message, $receiverId)
    {
        $this->message = $message;
        $this->receiverId = $receiverId;
    }

    public function broadcastOn()
    {
        return new Channel('chat.' . $this->receiverId); // Use the receiver's ID in the channel
    }

    public function broadcastAs()
    {
        return 'message.sent'; // Event name
    }
}
