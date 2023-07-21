<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TweetController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('auth/google', [LoginController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [LoginController::class, 'handleGoogleCallback']);
Route::get('tweets', [TweetController::class, 'show']);
Route::post('tweets', [TweetController::class, 'store']);
Route::get('tweets/{id}', [TweetController::class, 'delete']);
Route::post('logout', [LoginController::class, 'logout']);
Route::get('/', function () {
    return view('welcome');
});
