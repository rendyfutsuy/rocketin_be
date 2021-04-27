<?php

use Modules\Auth\Http\Controllers\UpdateProfile;
use Modules\Auth\Http\Controllers\HomeController;
use Modules\Auth\Http\Controllers\Auth\LoginController;
use Modules\Auth\Http\Controllers\Auth\RegisterController;
use Modules\Auth\Http\Controllers\Auth\ActivationController;
use Modules\Auth\Http\Controllers\Auth\ValidateCodeActivation;
use Modules\Auth\Http\Controllers\Auth\ResetPasswordController;
use Modules\Auth\Http\Controllers\Auth\ForgotPasswordController;
use Modules\Auth\Http\Controllers\Auth\ConfirmPasswordController;

/**
 * Api route di sini, gunakan class name seperti contoh.
 */

/**
 * Api route di sini, gunakan class name seperti contoh.
 */

// Route::get('url', [ContohController::class, 'index']); contoh dengan nama method
// Route::get('url', ContohInvocable::class); contoh invoke controller

Route::get('login', [LoginController::class, 'showLoginForm'])
    ->name('login');

Route::post('login', [LoginController::class, 'login'])
    ->name('login');

Route::post('logout', [LoginController::class, 'logout'])
    ->name('logout');

Route::get('register', [RegisterController::class, 'showRegistrationForm'])
    ->name('register');

Route::post('register', [RegisterController::class, 'register'])
    ->name('register');

Route::get('password/confirm', [ConfirmPasswordController::class, 'showConfirmForm'])
    ->name('password.confirm');

Route::post('password/confirm', [ConfirmPasswordController::class, 'confirm']);

Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');

Route::post('password/reset', [ResetPasswordController::class, 'reset'])
    ->name('password.update');

Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');

Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');

Route::get('account/activation', [ActivationController::class, 'showActivationForm'])
    ->name('account.activation');

Route::post('account/activation', [ActivationController::class, 'activate'])
    ->name('account.activation');

Route::get('account/activation-from-links', [ActivationController::class, 'activateUserFromLinks'])
    ->name('account.activation.from.links');

Route::get('account/send-activation-form', [ActivationController::class, 'sendActivationCodeForm'])
    ->name('account.send.activation.code.form');

Route::post('account/send/{e}', [ActivationController::class, 'sendActivationCode'])
    ->name('account.send.activation.code');

Route::get('account/resend/{user}', [ActivationController::class, 'resend'])
    ->name('account.resend.activation.code');

Route::post('account/send-to-phone/{e}', [ActivationController::class, 'sendActivationCodeToUserPhone'])
    ->name('account.send.to.phone.activation.code');

Route::get('account/resend-to-phone/{user}', [ActivationController::class, 'resendActivationCodeToUserPhone'])
    ->name('account.resend.to.phone.activation.code');

Route::post('validate/activation-code', ValidateCodeActivation::class)
    ->name('account.validate.activation.code');

Route::get('account/success', [ActivationController::class, 'success'])
    ->name('account.activation.success');


Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('reset-password/form', [ResetPasswordController::class, 'showForm'])
    ->name('auth.reset.password.form');

Route::get('reset-password/success', [ResetPasswordController::class, 'showSuccess'])
    ->name('auth.reset.password.success');    
