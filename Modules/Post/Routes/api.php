<?php

use Modules\Post\Http\Controllers\ShowAllPost;
use Modules\Post\Http\Controllers\PostController;
use Modules\Post\Http\Controllers\ShowAllWaitPost;
use Modules\Post\Http\Controllers\ShowAllRejectedPost;

/**
 * Api route di sini, gunakan class name seperti contoh.
 */

// Route::get('url', [ContohController::class, 'index']); contoh dengan nama metho]d
// Route::get('url', ContohInvocable::class); contoh invoke controller

Route::group(['prefix' => 'v1', 'middleware' => ['auth:api', 'has.jwt.token']], function () {
    Route::post('post/store', [PostController::class, 'save'])
        ->name('api.post.store');

    Route::post('post/update/{post}', [PostController::class, 'update'])
        ->name('api.post.update');

    Route::post('post/delete/{post}', [PostController::class, 'delete'])
        ->name('api.post.delete');

    Route::post('post/publish/{post}', [PostController::class, 'publish'])
        ->name('api.post.publish');
    
    Route::get('post/detail/{post}', [PostController::class, 'detail'])
        ->name('api.post.detail')
        ->middleware('admin.jwt');
    
    Route::get('post/list', [PostController::class, 'list'])
        ->name('api.post.list');

    Route::get('post/editor/list', ShowAllPost::class)
        ->name('api.post.editor.list')
        ->middleware('admin.jwt');    
    
    Route::get('post/wait-list', [PostController::class, 'waitList'])
        ->name('api.post.wait.list'); 
        
    Route::get('post/rejected-list', [PostController::class, 'rejectedList'])
        ->name('api.post.rejected.list');  

    Route::post('post/wait-list/{post}', [PostController::class, 'toWaitList'])
        ->name('api.post.to.wait.list');

    Route::post('post/rejected-list/{post}', [PostController::class, 'toRejectedList'])
        ->name('api.post.to.rejected.list')
        ->middleware('admin.jwt');

    Route::get('post/editor/list/wait', ShowAllWaitPost::class)
        ->name('api.post.editor.wait.list')
        ->middleware('admin.jwt');

    Route::get('post/editor/list/rejected', ShowAllRejectedPost::class)
        ->name('api.post.editor.rejected.list')
        ->middleware('admin.jwt');
});
    