<?php

use Modules\Video\Http\Controllers\VideoController;

/**
 * Api route di sini, gunakan class name seperti contoh.
 */

// Route::get('url', [ContohController::class, 'index']); contoh dengan nama metho]d
// Route::get('url', ContohInvocable::class); contoh invoke controller

Route::group(['prefix' => 'v1', 'middleware' => ['auth:api', 'has.jwt.token']], function () {
    Route::post('video/store', [VideoController::class, 'save'])
        ->name('api.post.store');

    Route::post('video/update/{video}', [VideoController::class, 'update'])
        ->name('api.post.update');

    Route::post('video/delete/{video}', [VideoController::class, 'delete'])
        ->name('api.post.delete');

    Route::post('video/publish/{video}', [VideoController::class, 'publish'])
        ->name('api.post.publish');

    Route::get('video/detail/{video}', [VideoController::class, 'detail'])
        ->name('api.post.detail')
        ->middleware('admin.jwt');

    Route::get('video/list', [VideoController::class, 'list'])
        ->name('api.post.list');
});
    