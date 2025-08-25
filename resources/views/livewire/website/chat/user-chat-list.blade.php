<div>
    <style>
        .chat-wrapper {
            display: flex;
            height: 90vh;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            font-family: 'Segoe UI', sans-serif;
        }

        .chat-users {
            width: 28%;
            background-color: #f8f9fa;
            border-right: 1px solid #ccc;
            overflow-y: auto;
        }

        .chat-users h3 {
            padding: 15px;
            margin: 0;
            background: #343a40;
            color: white;
            font-size: 18px;
        }

        .user-list-item {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
            transition: background 0.2s;
        }

        .user-list-item:hover,
        .user-list-item.active {
            background-color: #e9ecef;
        }

        .chat-box {
            flex: 1;
            display: flex;
            flex-direction: column;
            background-color: #fff;
        }

        .chat-header {
            padding: 15px;
            background-color: #f1f3f5;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .chat-messages {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background-color: #fdfdfd;
        }

        .message {
            margin-bottom: 12px;
            max-width: 60%;
            padding: 12px 18px;
            border-radius: 20px;
            word-wrap: break-word;
            font-size: 14px;
            position: relative;
        }

        .message.sent {
            background-color: #007bff;
            color: black;
            margin-left: auto;
            border-bottom-right-radius: 0;
        }

        .message.received {
            background-color: #e2e2e2;
            color: black;
            margin-right: auto;
            border-bottom-left-radius: 0;
        }

        .message-time {
            font-size: 10px;
            margin-top: 5px;
            text-align: right;
            color: #666;
        }

        .chat-input {
            display: flex;
            padding: 10px;
            border-top: 1px solid #ddd;
            background-color: #f8f9fa;
        }

        .chat-input input {
            flex: 1;
            padding: 10px 15px;
            border-radius: 20px;
            border: 1px solid #ccc;
            outline: none;
        }

        .chat-input button {
            margin-left: 10px;
            padding: 10px 20px;
            border: none;
            border-radius: 20px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }

        .chat-input button:hover {
            background-color: #0056b3;
        }
    </style>

    <div class="chat-wrapper">
        <!-- LEFT: User List -->
        <div class="chat-users">
            <h3>Chats</h3>
            @foreach ($users as $user)
                <div wire:click="selectUser({{ $user->id }})"
                    class="user-list-item {{ $selectedUserId == $user->id ? 'active' : '' }}">
                    {{ $user->name }}
                </div>
            @endforeach
        </div>

        <!-- RIGHT: Chat Box -->
        <div class="chat-box">
            <!-- Chat Header -->
            <div class="chat-header">
                @if ($selectedUserId)
                    Chat with {{ $users[$selectedUserId]->name ?? 'User' }}
                @else
                    Select a user to start chatting
                @endif
            </div>

            <!-- Messages -->
            <div class="chat-messages" wire:poll.3000ms>
                @if ($selectedUserId)
                    @forelse ($messages as $message)
                        <div class="message {{ $message->sender_id === auth()->id() ? 'sent' : 'received' }}">
                            {{ $message->message }}
                            <div class="message-time">{{ $message->created_at->format('h:i A') }}</div>
                        </div>
                    @empty
                        <p>No messages yet.</p>
                    @endforelse
                @else
                    <p style="color: #888;">Please select a conversation.</p>
                @endif
            </div>


            <!-- Input -->
            @if ($selectedUserId)
                <div class="chat-input">
                    <input type="text" wire:model.defer="newMessage" placeholder="Type your message...">
                    <button wire:click="sendMessage">Send</button>
                </div>
            @endif
        </div>
    </div>

</div>
