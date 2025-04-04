<?php

use Illuminate\Support\Str;

return [
    'driver' => env('SESSION_DRIVER', 'cookie'),
    'lifetime' => 120,
    'expire_on_close' => false,
    'encrypt' => false,
    'http_only' => true,
    'secure' => env('SESSION_SECURE_COOKIE', true), // Ubah ke true
    'same_site' => 'none',  // Harus 'none' agar bisa dipakai di berbagai domain
];

