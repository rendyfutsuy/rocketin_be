<?php

return [
    'name' => 'Auth',
    
    'code_generate' => [
        'length' =>  env('ACTIVATION_CODE_LENGTH', 6),
    ],

    'skip_activation' => env('SKIP_ACTIVATION', false),
    'block_banner_user' => env('BLOCK_BANNED_USER', true),
    'sms_provider' => env('SMS_PROVIDER', null)
];
