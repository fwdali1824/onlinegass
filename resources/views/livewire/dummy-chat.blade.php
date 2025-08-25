<div>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-id" content="{{ auth()->check() ? auth()->id() : '' }}"> <!-- ✅ -->
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="{{ asset('js/pusher.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const userIdMeta = document.head.querySelector('meta[name="user-id"]');

            if (!userIdMeta || !userIdMeta.content) {
                console.warn("User ID meta tag not found, skipping Pusher setup.");
                return;
            }

            const userId = userIdMeta.content;

            const pusher = new Pusher("your_app_key", {
                cluster: "ap2"
            });

            const channel = pusher.subscribe("chat." + userId);

            channel.bind("new.message", function(data) {
                console.log("Message received: ", data);

                if (!window.location.href.includes("/chat")) {
                    if (Notification.permission === "granted") {
                        new Notification("New Message", {
                            body: data.message.content,
                            icon: "/chat-icon.png",
                        });
                    } else {
                        Notification.requestPermission().then(function(permission) {
                            if (permission === "granted") {
                                new Notification("New Message", {
                                    body: data.message.content,
                                    icon: "/chat-icon.png",
                                });
                            }
                        });
                    }
                }
            });
        });
    </script>
</div>
