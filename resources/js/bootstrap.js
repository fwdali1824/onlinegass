import 'bootstrap';

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Echo from 'laravel-echo';
import io from 'socket.io-client';

// Initialize Echo with Socket.io
window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001',  // WebSocket server running on port 6001 (default for Laravel WebSockets)
});
