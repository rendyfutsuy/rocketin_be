<?php

namespace Modules\Message\ServiceManager\Providers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use Modules\Message\ServiceManager\Contracts\ProviderContract;

class NexmoProvider implements ProviderContract
{
    /** render header for Wordpress Authentication. */
    public function  send(...$params): array
    {
        $url = Config::get('message.nexmo.wa_reply_url');

        $params = [
            "to" => [
                "type" => "whatsapp", 
                "number" => $params['0']
            ],
            "from" => [
                "type" => "whatsapp",
                "number" => Config::get('message.nexmo.sender')
            ],
            "message" => [
                "content" => [
                    "type" => "text",
                    "text" => __('message::otp.sent') . ' ' . $params['1']
                ]
            ]
        ];

        $headers = [
            'Accept' => 'application/json',
            "Authorization" => "Basic " . base64_encode(Config::get('message.nexmo.api_key') . ":" . Config::get('message.nexmo.secret_key')),
        ];

        $response = Http::withHeaders($headers)->post($url, $params);
        
        Log::Info($response);

        return (array) json_decode($response);
    }
}
