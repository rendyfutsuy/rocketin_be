<?php

use Modules\Notification\Http\Controllers\NotificationController;

/**
 * Api route di sini, gunakan class name seperti contoh.
 */

// Route::get('url', [ContohController::class, ['index']); contoh dengan nama metho]d
// Route::get('url', ContohInvocable::class); contoh invoke controller

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'notification/demo'], function () {
        Route::post('/', function () {
            request()->validate([
                'token' => 'required',
            ]);
            
            $recipients = request()->token;

            return notification()
                ->to($recipients)
                ->priority('normal')
                ->timeToLive(0)
                ->data([
                    'title' => 'Test notification',
                    'body' => 'This is a test of notification',
                ])
                ->notification([
                    'title' => 'Test notification',
                    'body' => 'This is a test of notification',
                ])
                ->send();
        })->name('api.notification.demo');

        Route::get('/get/token', function () {
            return view('notification::token');
        })->name('api.notification.get.token');

        Route::get('/get/message/back', function () {
            return view('notification::receive_background_token');
        })->name('api.notification.get.message.back');

        Route::get('/get/message/fore', function () {
            return view('notification::receive_foreground_token');
        })->name('api.notification.demo.get.message.fore');
    });
    Route::group(['prefix' => 'notification/private', 'middleware' => ['auth:api', 'has.jwt.token']], function () {
        Route::post('/register/token', [NotificationController::class, 'registerDevice'])
            ->name('api.notification.register.device');
        
        Route::post('/send', [NotificationController::class, 'send'])
            ->name('api.notification.send');

        Route::post('/list', [NotificationController::class, 'list'])
            ->name('api.notification.list');

        Route::post('/store', [NotificationController::class, 'store'])
            ->name('api.notification.store');
    });
});
