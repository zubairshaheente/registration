<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostDataController;
use App\http\Controllers\EnterUserRecordController;


Route::get('/index', [EnterUserRecordController::class, 'index' ])->name('index_page');
Route::post('/index/indexsend', [EnterUserRecordController::class, 'indexsend' ])->name('indexsend');

// Login
Route::get('/login', [EnterUserRecordController::class, 'login'])->name('login');
Route::post('/', [EnterUserRecordController::class, 'loginsend'])->name('loginsend');

// Post
Route::get('/index', [PostDataController::class, 'index'])->name('index')->middleware('auth');
Route::post('/posts/create', [PostDataController::class, 'create'])->name('create')->middleware('auth');

// Logout
Route::get('/signout', [EnterUserRecordController::class, 'signout'])->name('signout');

Route::get('/', function () { return view('welcome'); });

// google api
Route::get('googleLogin', [EnterUserRecordController::class, 'googleLogin'])->name('google');
Route::get('login/google/callback', [EnterUserRecordController::class, 'googleHandle'])->name('google_page');

// auto create using jetstream cmd
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
    Route::get('/dashboard', function () { return view('dashboard');
    })->name('dashboard');
});

// FB
route::get('auth/facebook', [EnterUserRecordController::class, 'facebookpage'])->name('facebook');
route::get('auth/facebook/callback', [EnterUserRecordController::class, 'facebookredirect'])->name('facebookredirect');
