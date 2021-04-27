<?php

use Modules\Profile\Http\Controllers\UploadAvatar;
use Modules\Profile\Http\Controllers\UpdateProfile;

/**
 * Api route di sini, gunakan class name seperti contoh.
 */

/**
 * Api route di sini, gunakan class name seperti contoh.
 */

// Route::get('url', [ContohController::class, 'index']); contoh dengan nama method
// Route::get('url', ContohInvocable::class); contoh invoke controller

Route::post('/auth/update', UpdateProfile::class)->name('auth.profile.update');

Route::post('/auth/upload/avatar', UploadAvatar::class)->name('auth.profile.upload.avatar');

