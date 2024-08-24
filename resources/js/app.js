import './bootstrap';
import 'flowbite';

import Pusher from 'pusher-js';


window.Pikaday = require("pikaday");

const pusher = new Pusher(import.meta.env.VITE_PUSHER_APP_KEY, {
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    encrypted: true
});

