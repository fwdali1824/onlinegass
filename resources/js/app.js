import './bootstrap';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.PUSHER_APP_KEY,
    cluster: process.env.PUSHER_APP_CLUSTER,
    forceTLS: true,
});

// Listen to the channel for the message events
Echo.channel('chat.' + window.authUserId)
    .listen('MessageSent', (event) => {
        console.log(event);  // Handle the message and update the frontend
    });
