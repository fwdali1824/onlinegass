<?php

namespace App\Livewire\Website;

use App\Http\Controllers\HomeController;
use App\Models\Chats;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class MessageIconFloat extends Component
{
    public $showMessages = false;
    public $messageText = '';
    public $unreadCount = 0;

    public function mount()
    {
        $this->fetchUnreadCount();
    }

    public function toggleMessages()
    {
        $this->showMessages = !$this->showMessages;

        if ($this->showMessages) {
            // Mark unread messages as read
            Chats::where('receiver_id', Auth::id())
                ->whereNull('read_at')
                ->update(['read_at' => now()]);

            // Dispatch scroll event for Livewire v3
            $this->dispatch('scrollChatBox');
        }

        $this->fetchUnreadCount();
    }


    public function sendMessage()
    {
        if (trim($this->messageText) === '') return;

        Chats::create([
            'sender_id' => Auth::id(),
            'message' => $this->messageText,
        ]);

        $this->messageText = '';
    }

    public function fetchUnreadCount()
    {
        $this->unreadCount = Chats::where('receiver_id', Auth::id())
            ->whereNull('read_at')
            ->count();
    }

    #[Layout('components.layouts.website')]
    public function render()
    {
        $messages = Chats::with('sender')
            ->where(function ($query) {
                $query->where('sender_id', Auth::id())
                    ->orWhere('receiver_id', Auth::id());
            })
            ->orderBy('created_at', 'asc')
            ->get();

        $this->fetchUnreadCount();

        return view('livewire.website.message-icon-float', [
            'messages' => $messages,
        ]);
    }
}
