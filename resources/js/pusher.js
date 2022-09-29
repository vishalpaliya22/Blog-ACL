import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

window.listener = new Echo({
	broadcaster: 'pusher',
	key: process.env.MIX_ABLY_PUBLIC_KEY,
	cluster: process.env.MIX_PUSHER_APP_CLUSTER,
	forceTLS: true
});
