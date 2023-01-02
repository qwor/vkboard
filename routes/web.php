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

Route::get('/feed', [VkController::class, 'nextPage'])
    ->middleware('auth')
    ->name('feed.get');

Route::get('/search', [VkController::class, 'show'])
    ->middleware('auth');

Illuminate\Support\Facades\Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
