<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegisterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Api route di sini, gunakan class name seperti contoh.
 */

// Route::get('url', [ContohController::class, ['index']); contoh dengan nama metho]d
// Route::get('url', ContohInvocable::class); contoh invoke controller

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'public/auth'], function () {
        Route::post('login', LoginController::class)
            ->name('api.auth.login');
        Route::post('register', RegisterController::class)
            ->name('api.auth.register');
        Route::post('refresh', [AuthController::class, 'refresh'])
            ->name('api.auth.refresh');
        Route::post('check-token', [AuthController::class, 'checkToken'])
            ->name('api.auth.check-token');
    });
});

