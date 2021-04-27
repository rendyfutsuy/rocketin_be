<?php

use Modules\Auth\Http\Controllers\Api\MergeGuest;
use Modules\Auth\Http\Controllers\Api\SignInAsGuest;
use Modules\Auth\Http\Controllers\Api\UpdateProfile;
use Modules\Auth\Http\Controllers\Api\AuthController;
use Modules\Auth\Http\Controllers\Api\HomeController;
use Modules\Auth\Http\Controllers\Api\LoginController;
use Modules\Auth\Http\Controllers\Api\RegisterController;
use Modules\Auth\Http\Controllers\Auth\UsernameExistences;
use Modules\Auth\Http\Controllers\Api\ActivationController;
use Modules\Auth\Http\Controllers\Auth\UserEmailExistences;
use Modules\Auth\Http\Controllers\Auth\ResetEmailController;
use Modules\Auth\Http\Controllers\Auth\ResetPhoneController;
use Modules\Auth\Http\Controllers\Api\ResetPasswordController;

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
        Route::post('activate-account', [ActivationController::class, 'attemptActivation'])
            ->name('api.auth.activate.account');
        Route::post('resend-activation-code', [ActivationController::class, 'resend'])
            ->name('api.auth.resend.activation.code');
        Route::post('send-reset-code', [ResetPasswordController::class, 'sendVerificationEmail'])
            ->name('api.auth.send.reset.code');
        Route::post('resend-reset-code', [ResetPasswordController::class, 'resendVerificationEmail'])
            ->name('api.auth.resend.reset.code');
        Route::post('reset-password', [ResetPasswordController::class, 'reset'])
            ->name('api.auth.reset.password');
        Route::post('guest/register', SignInAsGuest::class)
            ->name('api.auth.login.guest');

        Route::get('guest/check-email', UserEmailExistences::class)
            ->name('api.auth.check.email');

        Route::get('guest/check-username', UsernameExistences::class)
            ->name('api.auth.check.username');

        Route::post('login/merge', MergeGuest::class)
            ->name('api.auth.login.merge')
            ->middleware(['auth:api', 'has.jwt.token']);

        Route::post('check-token', [AuthController::class, 'checkToken'])
            ->name('api.auth.check-token');
    });
    Route::group(['prefix' => 'private/auth', 'middleware' => ['auth:api']], function () {
        Route::post('logout', [AuthController::class, 'logout'])
            ->name('api.auth.logout');

        Route::get('home', [HomeController::class, 'index'])
            ->middleware('has.jwt.token')
            ->name('api.auth.home');

        Route::post('reset-email', [ResetEmailController::class, 'setResetEmailForm'])
            ->name('api.auth.reset.email')
            ->middleware(['has.jwt.token']);
        
        Route::post('reset-email/resend', [ResetEmailController::class, 'resendNotificationToNewEmail'])
            ->name('api.auth.resend.reset.email')
            ->middleware(['has.jwt.token']);
    });

    Route::group(['prefix' => 'private/auth'], function () {
        Route::get('reset-email/success', [ResetEmailController::class, 'success'])
            ->name('api.auth.reset.email.success');

        Route::get('reset-email/update', [ResetEmailController::class, 'updateEmail'])
            ->name('api.auth.reset.email.update');

        Route::post('reset-email/update', [ResetEmailController::class, 'updateEmailWithCode'])
            ->name('api.auth.reset.email.update.with.code')
            ->middleware(['auth:api', 'has.jwt.token']);

        Route::get('reset-phone/success', [ResetPhoneController::class, 'success'])
            ->name('api.auth.reset.phone.success');

        Route::get('reset-phone/update', [ResetPhoneController::class, 'updatePhone'])
            ->name('api.auth.reset.phone.update');

        Route::post('reset-phone/update', [ResetPhoneController::class, 'updatePhoneWithCode'])
            ->name('api.auth.reset.phone.update.with.code')
            ->middleware(['auth:api', 'has.jwt.token']);
    });
});
