<?php

use Modules\AdminPanel\Http\Controllers\AdminController;
use Modules\AdminPanel\Http\Controllers\Auth\LoginController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('admin/', function () {
    return redirect(route('super.admin.login.panel'));
});

// Auth::routes();

Route::get('admin/login', [LoginController::class, 'showLoginForm'])
    ->name('super.admin.login.panel');

Route::get('admin/home', [AdminController::class, 'index'])
    ->name('super.admin.home');

Route::get('admin/list/user', [AdminController::class, 'userList'])
    ->name('super.admin.list.user');

Route::get('admin/list/activity', [AdminController::class, 'activityList'])
    ->name('super.admin.list.activity');

Route::get('admin/list/post', [AdminController::class, 'postList'])
    ->name('super.admin.list.post');

Route::get('admin/list/tag', [AdminController::class, 'tagList'])
    ->name('super.admin.list.tag');

Route::get('admin/list/category', [AdminController::class, 'categoryList'])
    ->name('super.admin.list.category');

Route::get('admin/detail/post/{post}', [AdminController::class, 'postDetail'])
    ->name('super.admin.detail.post');

Route::get('admin/wait-list/post', [AdminController::class, 'postWaitList'])
    ->name('super.admin.list.post.wait');

Route::get('admin/rejected-list/post', [AdminController::class, 'postRejectedList'])
    ->name('super.admin.list.post.rejected');

Route::get('admin/list/media', [AdminController::class, 'mediaList'])
    ->name('super.admin.list.media');

Route::get('admin/create/post', [AdminController::class, 'postCreate'])
    ->name('super.admin.create.post');

Route::get('admin/edit/post/{post}', [AdminController::class, 'postEdit'])
    ->name('super.admin.edit.post');
