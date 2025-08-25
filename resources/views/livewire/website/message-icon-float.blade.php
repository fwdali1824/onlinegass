<div>
    <!-- Font Awesome (if not already included) -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <div>
        <!-- Floating Button -->
        <a href="javascript:void(0)" wire:click="toggleMessages" class="float" title="Chat with us">
            <i class="fa fa-comments my-float"></i>

            @if ($unreadCount > 0)
                <span class="notification-badge">{{ $unreadCount }}</span>
            @endif
        </a>

        <!-- Floating Chat Box -->
        @if ($showMessages)
            <div class="chat-box card shadow-lg">
                <div style="display: flex;justify-content: space-between;flex-wrap: nowrap;flex-direction: row;"
                    class="card-header text-black d-flex justify-content-between align-items-center">
                    <strong>Support</strong>
                    <button type="button" class="btn-close" wire:click="toggleMessages"></button>
                </div>

                <div class="card-body chat-body">
                    <div class="card-body chat-body" wire:poll.10s>
                        @foreach ($messages as $msg)
                            @if ($msg->sender_id === Auth::id())
                                <!-- Outgoing Message -->
                                <div class="message outgoing text-end mb-2">
                                    <div class="bg-primary text-white p-2 rounded d-inline-block">
                                        {{ $msg->message }}
                                        <div class="small mt-1 text-end text-light" style="font-size: 11px;">
                                            You •
                                            {{ $msg->created_at->setTimezone('Asia/Karachi')->format('d M Y, h:i A') }}
                                        </div>
                                    </div>
                                </div>
                            @else
                                <!-- Incoming Message -->
                                <div class="message incoming mb-2">
                                    <div class="bg-light p-2 rounded d-inline-block">
                                        {{ $msg->message }}
                                        <div class="small mt-1 text-black" style="font-size: 11px;">
                                            {{ $msg->sender->name ?? 'Support' }} •
                                            {{ $msg->created_at->setTimezone('Asia/Karachi')->format('d M Y, h:i A') }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>


                </div>

                <div class="card-footer bg-white">
                    <form wire:submit.prevent="sendMessage" class="input-group">
                        <input type="text" wire:model.defer="messageText" class="form-control"
                            placeholder="Type a message...">
                        <button class="btn btn-success" type="submit">Send</button>
                    </form>
                </div>
            </div>
        @endif
    </div>

    <style>
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: red;
            color: white;
            border-radius: 50%;
            font-size: 12px;
            padding: 2px 6px;
        }

        .float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 93px;
            right: 40px;
            background-color: #25d366;
            color: #FFF;
            border-radius: 50%;
            text-align: center;
            font-size: 30px;
            box-shadow: 2px 2px 3px #999;
            z-index: 1060;
            transition: all 0.3s ease-in-out;
        }

        .message .incoming .mb-2 {
            padding: 12px;
            margin-bottom: 8px;
        }

        .float:hover {
            transform: scale(1.1);
            background-color: #1ebea5;
        }

        .my-float {
            margin-top: 16px;
        }

        .chat-box {
            position: fixed;
            bottom: 110px;
            right: 40px;
            width: 320px;
            height: 500px;
            display: flex;
            padding: 20px;
            flex-direction: column;
            z-index: 1059;
            background: white;
            color: black;
        }

        .input-group {
            position: relative;
            display: table;
            display: flex;
            border-collapse: separate;
        }

        .chat-body {
            flex: 1;
            overflow-y: auto;
            /* background-color: #f8f9fa; */
            padding: 10px;
        }

        .chat-body .message {
            max-width: 100%;
        }

        .chat-body .incoming {
            text-align: left;
        }

        .chat-body .outgoing {
            text-align: right;
        }

        .card-footer {
            border-top: 1px solid #ddd;
        }

        .bg-primary {
            color: #fff;
            background-color: #337ab7;
            padding: 12px;
            margin-bottom: 8px;
        }
    </style>

    <script>
        document.addEventListener('livewire:load', function() {
            const scrollChatToBottom = () => {
                const chatBody = document.querySelector('.chat-body');
                if (chatBody) {
                    chatBody.scrollTop = chatBody.scrollHeight;
                }
            };

            Livewire.hook('message.processed', () => {
                scrollChatToBottom();
            });

            window.addEventListener('scrollChatBox', scrollChatToBottom);
        });
    </script>

</div>
