<?php

namespace App\Livewire\Website\Chat;

use App\Events\MessageSent;
use App\Models\Chats;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

class UserChatList extends Component
{
    #[Layout('components.layouts.websiteDashboard')]
    public $selectedUserId = null;

    public function selectUser($userId)
    {
        $this->selectedUserId = $userId;
    }

    public $newMessage = '';

    public function sendMessage()
    {
        if (trim($this->newMessage) === '') return;

        $message = Chats::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $this->selectedUserId,
            'message' => $this->newMessage,
        ]);

        // Broadcast the message to the receiver's channel
        broadcast(new MessageSent($message, $this->selectedUserId))->toOthers();

        $this->newMessage = '';
        // $this->loadMessages(); // Reload messages
    }




    public function render()
    {
        $authUserId = auth()->id();

        $chats = Chats::where('sender_id', $authUserId)
            ->orWhere('receiver_id', $authUserId)
            ->orderBy('created_at', 'desc')
            ->get();

        $conversations = $chats->groupBy(function ($chat) use ($authUserId) {
            return $chat->sender_id === $authUserId ? $chat->receiver_id : $chat->sender_id;
        });

        $userIds = $conversations->keys();
        $users = User::whereIn('id', $userIds)->get()->keyBy('id');

        $messages = [];
        if ($this->selectedUserId) {
            $messages = Chats::where(function ($query) use ($authUserId) {
                $query->where('sender_id', $authUserId)
                    ->orWhere('receiver_id', $authUserId);
            })->where(function ($query) {
                $query->where('sender_id', $this->selectedUserId)
                    ->orWhere('receiver_id', $this->selectedUserId);
            })->orderBy('created_at')->get();
        }

        return view('livewire.website.chat.user-chat-list', [
            'users' => $users,
            'messages' => $messages,
        ]);
    }
}
