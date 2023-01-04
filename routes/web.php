<?php

use App\Http\Controllers\FilterController;
use App\Http\Controllers\GroupWallController;
use App\Http\Controllers\UserWallController;
use App\Http\Controllers\VkController;
use ATehnix\VkClient\Auth;
use Illuminate\Http\Request;
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

Route::redirect('/', 'filters');

Route::get('/feed/{filter}', [VkController::class, 'search'])
    ->middleware('auth')
    ->name('feed.show');

Route::get('/feed_next', [VkController::class, 'feedNextPage'])
    ->middleware('auth')
    ->name('feed.nextPage');

Route::get('/search', [VkController::class, 'show'])
    ->middleware('auth');

Route::get('/wall/{wall}', [VkController::class, 'wall'])
    ->middleware('auth')
    ->name('wall')
    ->where('wall', '[A-Za-z0-9-]+');

Route::get('/wall/{wall}/nextPage', [VkController::class, 'wallNextPage'])
    ->middleware('auth')
    ->name('wall.nextPage')
    ->where('wall', '[A-Za-z0-9-]+');


Route::resource('filters', FilterController::class)
    ->only('index', 'create', 'store', 'edit', 'update', 'destroy')
    ->middleware('auth');

Route::resource('userWalls', UserWallController::class)
    ->only('index', 'store', 'destroy')
    ->middleware('auth');

Route::resource('groupWalls', GroupWallController::class)
    ->only('index', 'store', 'destroy')
    ->middleware('auth');

Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'App\Http\Controllers\LanguageController@switchLang']);

Illuminate\Support\Facades\Auth::routes();
