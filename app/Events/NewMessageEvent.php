<?php
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class NewMessageEvent implements ShouldBroadcast
{
    use SerializesModels;

    public $message;
    public $receiverId;

    public function __construct($message, $receiverId)
    {
        $this->message = $message;
        $this->receiverId = $receiverId;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('chat.' . $this->receiverId);
    }

    public function broadcastAs()
    {
        return 'new.message';
    }
}
