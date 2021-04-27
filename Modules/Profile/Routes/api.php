<?php

use Modules\Profile\Http\Controllers\Api\UploadAvatar;
use Modules\Profile\Http\Controllers\Api\UpdateProfile;
use Modules\Profile\Http\Controllers\Api\UpdatePassword;
use Modules\Profile\Http\Controllers\Api\ShowHomeActivity;

/**
 * Api route di sini, gunakan class name seperti contoh.
 */

// Route::get('url', [ContohController::class, ['index']); contoh dengan nama metho]d
// Route::get('url', ContohInvocable::class); contoh invoke controller

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'private/auth', 'middleware' => ['auth:api', 'has.jwt.token']], function () {
        Route::post('update', UpdateProfile::class)
            ->name('api.auth.profile.update');

        Route::post('upload/avatar', UploadAvatar::class)
            ->name('api.auth.profile.upload.avatar');

        Route::get('profile', ShowHomeActivity::class)
            ->name('api.profile.home');

        Route::post('change/password', UpdatePassword::class)
            ->name('api.auth.profile.change.password');
    });
});
