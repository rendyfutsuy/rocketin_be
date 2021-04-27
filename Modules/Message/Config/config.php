<?php

return [
    'name' => 'Message',
    'provider' => env('MESSAGE_PROVIDER', 'nexmo'),
    'need_message_otp' => env('NEED_MESSAGE_OTP', false),
];
