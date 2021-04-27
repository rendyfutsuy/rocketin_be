<?php

return [
    'api_key' => env('NEXMO_API_KEY', null),
    'secret_key'=> env('NEXMO_API_SECRET', null),
    'sender' => env('NEXMO_SENDER', "14157386170"),
    'wa_reply_url' => env('NEXMO_WHATS_APP_URL', 'https://messages-sandbox.nexmo.com/v0.1/messages')
];
