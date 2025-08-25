<?php

namespace App\Http\Livewire;

use App\Models\Chats;
use Livewire\Component;
use Carbon\Carbon;

class Notifications extends Component
{
    public $notifications;

    public function mount()
    {
        // Get notifications for the logged-in user
        $this->notifications = Chats::where('receiver_id', auth()->user()->id)  // Get notifications for the logged-in user
            ->whereNull('read_at')
            ->latest()
            ->get();
    }

    public function markAsRead($notificationId)
    {
        $notification = Chats::find($notificationId);
        $notification->read_at = Carbon::now();
        $notification->save();

        // Re-fetch the notifications after marking one as read
        $this->notifications = Chats::where('receiver_id', $notification->receiver_id)
            ->whereNull('read_at')
            ->latest()
            ->get();
    }

    public function render()
    {
        return view('livewire.notifications')->with([
            'notifications' => $this->notifications,
        ])->extends('layouts.app')->section('content')->poll(5000);  // Polling every 5 seconds for new notifications
    }
}
