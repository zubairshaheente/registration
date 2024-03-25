<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleApiController;

Route::get('googleLogin', [GoogleApiController::class, 'googleLogin'])->name('google');
Route::get('/login/google/callback', [GoogleApiController::class, 'callback'])->name('callback');
Route::post('/', [GoogleApiController::class, 'loginsend'])->name('loginsend');

Route::get('/', function () { return view('welcome'); });