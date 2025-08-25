<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;


class ChatNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['broadcast'];
    }
    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */


    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'message' => $this->message,
            'user' => $notifiable->name,
        ]);
    }
}
