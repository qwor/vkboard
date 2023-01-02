<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::post('/feed', [VkController::class, 'search'])
    ->middleware('auth')
    ->name('feed.post');

Route::get('/feed', [VkController::class, 'feedNextPage'])
    ->middleware('auth')
    ->name('feed.get');

Route::get('/search', [VkController::class, 'show'])
    ->middleware('auth');

Route::get('/profile/{profile_id}', [VkController::class, 'profile'])
    ->middleware('auth')
    ->name('profile')
    ->where('profile_id', '[A-Za-z0-9-]+');

Route::get('/profile/{profile_id}/nextPage', [VkController::class, 'profileNextPage'])
    ->middleware('auth')
    ->name('profile.nextPage')
    ->where('profile_id', '[A-Za-z0-9-]+');


Illuminate\Support\Facades\Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
