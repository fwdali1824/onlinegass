<?php

namespace App\Livewire\Admin\Chat;

use App\Events\MessageSent;
use App\Http\Controllers\HomeController;
use App\Models\Chats;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChatList extends Component
{
    public $receiver_id;
    public $receiver;
    public $messageText;
    public $messages = [];
    public $users;

    public function mount($receiver_id = null)
    {
        $this->users = User::where('id', '!=', Auth::id())->where('role', 'customer')->get();

        if ($receiver_id) {
            $this->receiver_id = $receiver_id;
            $this->receiver = User::find($receiver_id);
            $this->loadMessages();
        }
    }

    public function selectReceiver($userId)
    {
        $this->receiver_id = $userId;

        // ✅ Mark unread messages from this user as read
        Chats::orwhere('sender_id', $userId)
            // ->orwhere('receiver_id', Auth::user()->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);


        $this->receiver_id = $userId;
        $this->receiver = User::find($userId);

        $this->loadMessages(); // your function to get messages
    }


    public function loadMessages()
    {
        $this->messages = Chats::where(function ($query) {
            $query
                ->where('sender_id', $this->receiver_id)
                ->orwhere('receiver_id', $this->receiver_id);
        })->get();
    }

    public function sendMessage()
    {
        $message = Chats::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $this->receiver_id,
            'message' => $this->messageText,
        ]);

        $userRec = User::where('id', $this->receiver_id)->first();
        HomeController::sendNotification($userRec->fcm_token, Auth::user()->name, $this->messageText);

        // Broadcast the message to the receiver's channel
        broadcast(new MessageSent($message, $this->receiver_id));

        $this->messageText = '';
        $this->loadMessages();
    }

    public function render()
    {

        if ($this->receiver_id) {
            $this->loadMessages(); // ✅ Always fetch latest messages
        }

        return view('livewire.admin.chat.chat-list', [
            'receiver' => $this->receiver,
            'users' => $this->users,
            'messages' => $this->messages,
        ]);
    }
}
