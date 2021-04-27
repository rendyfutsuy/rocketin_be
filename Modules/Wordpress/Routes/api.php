<?php

use Modules\Wordpress\Http\Controllers\StoreTag;
use Modules\Wordpress\Http\Controllers\GetTagList;
use Modules\Wordpress\Http\Controllers\StoreCategory;
use Modules\Wordpress\Http\Controllers\GetCategoryList;

/**
 * Api route di sini, gunakan class name seperti contoh.
 */

// Route::get('url', [ContohController::class, ['index']); contoh dengan nama metho]d
// Route::get('url', ContohInvocable::class); contoh invoke controller

Route::get('v1/tags', GetTagList::class)->name('api.tags.list');
Route::get('v1/categories', GetCategoryList::class)->name('api.categories.list');
Route::post('v1/tags/store', StoreTag::class)->name('api.tags.store');
Route::post('v1/categories/store', StoreCategory::class)->name('api.categories.store');
