import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


import Echo from 'laravel-echo';
window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'any-key', // wajib ada meski dummy
    wsHost: window.location.hostname,
    wsPort: 6001, // default Laravel WebSocket
    forceTLS: false,
    disableStats: true,
});
