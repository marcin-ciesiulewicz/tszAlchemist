<?php

use Illuminate\Support\Facades\Route;

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

Route::redirect('/', 'login');

Auth::routes(['register'=>false]);

Route::group(['middleware'=>['auth']], function(){

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('/package-elements', \App\Http\Controllers\PackageElementsController::class);

    Route::resource('/packages', \App\Http\Controllers\PackageController::class);

    Route::resource('/campaigns', \App\Http\Controllers\CampaignController::class);

    Route::get('/tags', [\App\Http\Controllers\TagController::class, 'index'])->name('tags.index');
    Route::post('/tags/store-tag', [\App\Http\Controllers\TagController::class, 'storeTag'])->name('tags.storeTag');
    Route::post('/tags/remove-tag', [\App\Http\Controllers\TagController::class, 'removeTag'])->name('tags.removeTag');

});
