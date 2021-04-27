<?php

return [
    'name' => 'Wordpress',
    'basic_auth_username' => env('WP_BASIC_USERNAME', 'admin'),
    'basic_auth_password' => env('WP_BASIC_PASSWORD', 'admin'),
    'wp_url' => env('WP_URL', 'http://wordpress.test/wp-json'),
    'provider' => env('WP_PROVIDER', 'basic'),
];
