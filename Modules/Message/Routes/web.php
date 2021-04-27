<?php

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\Message\ServiceManager\Message;

/**
 * Api route di sini, gunakan class name seperti contoh.
 */

/**
 * Api route di sini, gunakan class name seperti contoh.
 */

// Route::get('url', [ContohController::class, 'index']); contoh dengan nama method
// Route::get('url', ContohInvocable::class); contoh invoke controller

Route::post('/message/send/otp', function(Request $request) {
    // TODO: validate incoming params first!

    $message =  app()->make(Message::class);
    $message->provider()->send('6281572249213', '23rwefesteew');

    return response()->json([
        'message' => __('message::otp.success'),
    ]);

})->name('message.send.otp');

Route::post('/webhooks/inbound', function(Request $request) {
    $data = $request->all();
    $text = $data['message']['content']['text'];
    $number = intval($text);
    Log::Info($number);
    if($number > 0) {
        $random = rand(1, 8);
        Log::Info($random);
        $respond_number = $number * $random;
        Log::Info($respond_number);
        $url = "https://messages-sandbox.nexmo.com/v0.1/messages";
        $params = ["to" => ["type" => "whatsapp", "number" => $data['from']['number']],
            "from" => ["type" => "whatsapp", "number" => "14157386170"],
            "message" => [
                "content" => [
                    "type" => "text",
                    "text" => "The answer is " . $respond_number . ", we multiplied by " . $random . "."
                ]
            ]
        ];
        $headers = ["Authorization" => "Basic " . base64_encode(env('NEXMO_API_KEY') . ":" . env('NEXMO_API_SECRET'))];
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $url, ["headers" => $headers, "json" => $params]);
        $data = $response->getBody();
    }
    Log::Info($data);
});

Route::post('/webhooks/status', function(Request $request) {
    $data = $request->all();
    Log::Info($data);
});