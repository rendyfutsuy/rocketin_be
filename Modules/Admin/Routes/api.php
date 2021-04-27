<?php

/**
 * Api route di sini, gunakan class name seperti contoh.
 */

use Modules\Admin\Http\Controllers\EnableUser;
use Modules\Admin\Http\Controllers\DisableUser;
use Modules\Admin\Http\Controllers\ShowAllUser;
use Modules\Admin\Http\Controllers\PostController;
use Modules\Admin\Http\Controllers\ShowDetailUser;
use Modules\Admin\Http\Controllers\ShowSiteStatic;
use Modules\Admin\Http\Controllers\RegisterNewAdmin;
use Modules\Admin\Http\Controllers\Api\LoginController;
use Modules\Admin\Http\Controllers\User\ActivityController;


// Route::get('url', [ContohController::class, ['index']); contoh dengan nama metho]d
// Route::get('url', ContohInvocable::class); contoh invoke controller

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'public/admin'], function () {
        Route::post('login', LoginController::class)
            ->name('api.admin.login');
    });
    Route::group(['prefix' => 'private/admin', 'middleware' => ['auth:admin', 'admin.jwt']], function () {
        Route::post('logout', [LoginController::class, 'logout'])
            ->name('api.admin.logout');

        Route::post('refresh/token', [LoginController::class, 'refreshToken'])
            ->name('api.admin.refresh.token');

        Route::post('home', function () {
            return auth()->user();
        })->name('api.admin.home');

        Route::get('all/user/activity/year', [ActivityController::class, 'activityThisYear'])
            ->name('api.admin.user.all.activity.year');

        Route::get('all/post/year', [PostController::class, 'postThisYear'])
            ->name('api.admin.all.post.year');

        Route::get('all/post/year/{user}', [PostController::class, 'personalPostThisYear'])
            ->name('api.personal.all.post.year');
        
        Route::post('/enable/{user}', EnableUser::class)
            ->name('api.admin.enable.user');

        Route::post('/disable/{user}', DisableUser::class)
            ->name('api.admin.disable.user');

        Route::get('/user/all/list', [ActivityController::class, 'list'])
            ->name('api.admin.user.activity.list');

        Route::get('activity-code/list',[ ActivityController::class, 'activityCodeList'])
            ->name('api.admin.list.activity.codes');

        Route::get('user/list', ShowAllUser::class)
            ->name('api.admin.all.user');

        Route::get('/detail/user/{user}', ShowDetailUser::class)
            ->name('api.admin.user.detail');

        Route::post('/register', RegisterNewAdmin::class)
            ->name('api.admin.register.admin');

        Route::get('/site/static', ShowSiteStatic::class)
            ->name('api.admin.site.static');
    });
});