<?php

use Modules\Video\Http\Controllers\VideoController;

/**
 * Api route di sini, gunakan class name seperti contoh.
 */

// Route::get('url', [ContohController::class, 'index']); contoh dengan nama metho]d
// Route::get('url', ContohInvocable::class); contoh invoke controller

Route::group(['prefix' => 'v1', 'middleware' => ['auth:api', 'has.jwt.token']], function () {
    Route::post('video/store', [VideoController::class, 'save'])
        ->name('api.post.store')->middleware('admin.jwt');

    Route::post('video/update/{video}', [VideoController::class, 'update'])
        ->name('api.post.update')->middleware('admin.jwt');

    Route::post('video/delete/{video}', [VideoController::class, 'delete'])
        ->name('api.post.delete')->middleware('admin.jwt');

    Route::get('video/detail/{video}', [VideoController::class, 'detail'])
        ->name('api.post.detail');

    Route::get('video/list', [VideoController::class, 'list'])
        ->name('api.post.list');
});
    