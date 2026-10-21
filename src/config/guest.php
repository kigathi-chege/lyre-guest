<?php

return [
    /*
    | Look up the visitor's location when a guest is created. Off by default: it is an external
    | HTTP call on the request path, and behind a server-side renderer the API only sees the
    | renderer's IP, so the result describes the server rather than the visitor. Enable only
    | when the real client IP reaches the API (trusted proxies) and a local driver is used.
    */
    'geolocation' => env('GUEST_GEOLOCATION', false),
];
