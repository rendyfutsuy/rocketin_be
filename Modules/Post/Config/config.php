<?php

return [
    'name' => 'Post',
    'min_content' => env('WP_CONTENT_MIN_WORDS', 10),
    'min_gallery_images' => env('WP_CONTENT_MIN_IMAGES', 3),
    'max_title' => env('WP_MAX_TITLE', 50),
    'wp_base_url' => env('POST_BASE_URL', 'http://wordpress.test'),
];
