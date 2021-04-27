<?php

use Modules\Media\Http\Controllers\ShowAllMedia;
use Modules\Media\Http\Controllers\MediaController;

/**
 * Api route di sini, gunakan class name seperti contoh.
 */

// Route::get('url', [ContohController::class, 'index']); contoh dengan nama metho]d
// Route::get('url', ContohInvocable::class); contoh invoke controller

Route::group(['prefix' => 'v1', 'middleware' => ['auth:api', 'has.jwt.token']], function () {
    Route::post('media/store', [MediaController::class, 'save'])
        ->name('api.media.store');

    Route::post('media/update/{media}', [MediaController::class, 'update'])
        ->name('api.media.update');

    Route::post('media/delete/{media}', [MediaController::class, 'delete'])
        ->name('api.media.delete');

    Route::get('media/detail/{media}', [MediaController::class, 'detail'])
        ->name('api.media.detail');

    Route::get('media/list', [MediaController::class, 'list'])
        ->name('api.media.list');

    Route::get('media/editor/list', ShowAllMedia::class)
        ->name('api.media.editor.list')
        ->middleware('admin.jwt');  
});