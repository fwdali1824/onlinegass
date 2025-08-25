<div class="row clearfix">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .chat-app {
            height: 87vh;
            display: flex;
            flex-direction: row;
            border: 1px solid #ccc;
        }

        .people-list {
            width: 25%;
            border-right: 1px solid #ccc;
            overflow-y: auto;
        }

        .chat {
            width: 75%;
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            padding: 15px;
            border-bottom: 1px solid #ccc;
            background-color: #f7f7f7;
        }

        .chat-history {
            flex: 1;
            overflow-y: auto;
            padding: 15px;
            background: #f1f1f1;
        }

        .chat-app .people-list {
            width: 280px;
            position: absolute;
            left: 0;
            top: 0;
            padding: 2px;
            z-index: 7;
        }

        .chat-message {
            padding: 15px;
            border-top: 1px solid #ccc;
            background-color: #fff;
        }

        /* Message Styling */
        .message-row {
            display: flex;
            margin-bottom: 10px;
        }

        .message-sent {
            justify-content: flex-end;
        }

        .message-received {
            justify-content: flex-start;
        }

        .message-bubble {
            max-width: 60%;
            padding: 10px 15px;
            border-radius: 18px;
            position: relative;
            font-size: 14px;
            line-height: 1.4;
        }

        .sent-bubble {
            background-color: #007bff;
            color: white;
            border-bottom-right-radius: 0;
        }

        .received-bubble {
            background-color: #e4e6eb;
            color: black;
            border-bottom-left-radius: 0;
        }

        .message-time {
            font-size: 10px;
            color: #666;
            margin-top: 3px;
            text-align: right;
        }
    </style>

    <div class="col-lg-12 mt-2">



        <div class="card chat-app">
            <!-- User List -->
            <div class="people-list">
                <div class="input-group p-2">
                    <input type="text" class="form-control" placeholder="Search..." disabled>
                </div>
                <ul class="list-unstyled chat-list mt-2 mb-0">
                    @foreach ($users as $user)
                        @php
                            $unread = \App\Models\Chats::where('sender_id', $user->id)
                                // ->orwhere('receiver_id', auth()->id())
                                ->whereNull('read_at')
                                ->count();
                        @endphp

                        <li wire:click="selectReceiver({{ $user->id }})"
                            class="clearfix {{ $receiver_id === $user->id ? 'active' : '' }}">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}" alt="avatar" />
                            <div class="about">
                                <div class="name">
                                    {{ $user->name }}
                                    <br>
                                    <span style="font-size: 12px">{{ $user->role }}</span>
                                    @if ($unread > 0)
                                        <span class="badge bg-danger">{{ $unread }}</span>
                                    @endif
                                </div>

                            </div>
                        </li>
                    @endforeach

                </ul>
            </div>

            <!-- Chat Panel -->
            <div class="chat">
                <div class="chat-header clearfix">
                    @if ($receiver)
                        <div class="row">
                            <div class="col-lg-6">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($receiver->name) }}"
                                    alt="avatar">
                                <div class="chat-about">
                                    <h6 class="m-b-0">{{ $receiver->name }}</h6>
                                    <small>Last seen: recently</small>
                                </div>
                            </div>
                        </div>
                    @else
                        <div>Select a user to start chat</div>
                    @endif
                </div>

                <!-- Messages with wire:poll -->
                <div class="chat-history" wire:poll.3000ms id="chat-history">
                    @foreach ($messages as $msg)
                        @php
                            $isMe = $msg->sender_id === auth()->id();
                        @endphp
                        <div class="message-row {{ $isMe ? 'message-sent' : 'message-received' }}">
                            <div class="message-bubble {{ $isMe ? 'sent-bubble' : 'received-bubble' }}">
                                {{ $msg->message }}
                                <div class="message-time">
                                    {{ $msg->created_at->timezone('Asia/Karachi')->format('h:i A') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Message Input -->
                @if ($messages)
                    <div class="chat-message clearfix">
                        <form wire:submit.prevent="sendMessage">
                            <div class="input-group mb-0">
                                <input type="text" wire:model="messageText" class="form-control"
                                    placeholder="Enter text here..." autocomplete="off">
                                <button class="btn btn-primary" type="submit">
                                    Send
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const chatHistory = document.getElementById("chat-history");

            // Function to scroll to bottom
            function scrollToBottom() {
                if (chatHistory) {
                    chatHistory.scrollTop = chatHistory.scrollHeight;
                }
            }

            // Watch for the 'active' class on <li> elements
            const observer = new MutationObserver(() => {
                // Find the active li
                const activeItem = document.querySelector(".chat-list li.active");
                if (activeItem) {
                    // Wait for Livewire to finish rendering messages
                    setTimeout(scrollToBottom, 100);
                }
            });

            // Observe class changes in chat list container
            const chatList = document.querySelector(".chat-list");
            if (chatList) {
                observer.observe(chatList, {
                    subtree: true,
                    attributes: true,
                    attributeFilter: ["class"]
                });
            }
        });
    </script>


</div>
