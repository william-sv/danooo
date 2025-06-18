<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['GET', 'POST', 'OPTIONS'],

    'allowed_origins' => ['https://www.songji.top'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => [
        'Content-Type',
        'X-Requested-With',
        'X-CSRF-Token',
        'Authorization',
        'Accept',
        'Origin',
        'X-Api-Token',
        'X-Requested-With',
        'X-Socket-ID'],

    'exposed_headers' => [
        'Content-Length',
        'Content-Range',
        'X-RateLimit-Limit',
        'X-RateLimit-Remaining'
    ],

    'max_age' => 3600,

    'supports_credentials' => true,

];
