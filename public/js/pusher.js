document.addEventListener("DOMContentLoaded", function () {
    const userId = document.head.querySelector('meta[name="user-id"]').content;

    const pusher = new Pusher("your_app_key", {
        cluster: "ap2"
    });

    const channel = pusher.subscribe("chat." + userId); // 👈 Public channel

    channel.bind("new.message", function (data) {
        console.log("Message received: ", data);

        if (!window.location.href.includes("/chat")) {
            if (Notification.permission === "granted") {
                new Notification("New Message", {
                    body: data.message.content,
                    icon: "/chat-icon.png",
                });
            } else {
                Notification.requestPermission().then(function (permission) {
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
