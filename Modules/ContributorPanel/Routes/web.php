<?php

use Modules\ContributorPanel\Http\Controllers\Auth\LoginController;
use Modules\ContributorPanel\Http\Controllers\Auth\ShowRegisterForm;
use Modules\ContributorPanel\Http\Controllers\ContributorController;
use Modules\ContributorPanel\Http\Controllers\Auth\ShowActivationForm;


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

Route::get('seller/', function () {
    return redirect(route('contributor.login.panel'));
});

// Auth::routes();

Route::get('seller/login', [LoginController::class, 'showLoginForm'])
    ->name('contributor.login.panel');

Route::get('seller/activation', ShowActivationForm::class)
    ->name('contributor.activation.panel');

Route::get('seller/register', ShowRegisterForm::class)
    ->name('contributor.register.panel');

Route::get('seller/forget-password', [ContributorController::class, 'forgetPassword'])
    ->name('contributor.forget-password.panel');

Route::get('seller/home', [ContributorController::class, 'index'])
    ->name('contributor.home');

Route::get('seller/list/user', [ContributorController::class, 'userList'])
    ->name('contributor.list.user');

Route::get('seller/list/activity', [ContributorController::class, 'activityList'])
    ->name('contributor.list.activity');

Route::get('seller/list/post', [ContributorController::class, 'postList'])
    ->name('contributor.list.post');

Route::get('seller/list/tag', [ContributorController::class, 'tagList'])
    ->name('contributor.list.tag');

Route::get('seller/list/category', [ContributorController::class, 'categoryList'])
    ->name('contributor.list.category');

Route::get('seller/detail/post/{post}', [ContributorController::class, 'postDetail'])
    ->name('contributor.detail.post');

Route::get('seller/wait-list/post', [ContributorController::class, 'postWaitList'])
    ->name('contributor.list.post.wait');

Route::get('seller/rejected-list/post', [ContributorController::class, 'postRejectedList'])
    ->name('contributor.list.post.rejected');

Route::get('seller/list/media', [ContributorController::class, 'mediaList'])
    ->name('contributor.list.media');

Route::get('seller/create/post', [ContributorController::class, 'postCreate'])
    ->name('contributor.create.post');

Route::get('seller/edit/post/{post}', [ContributorController::class, 'postEdit'])
    ->name('contributor.edit.post');

Route::get('seller/edit/profile', [ContributorController::class, 'profileEdit'])
    ->name('contributor.edit.profile');
