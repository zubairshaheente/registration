<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostDataController;
use App\http\Controllers\EnterUserRecordController;


Route::get('/index', [EnterUserRecordController::class, 'index' ])->name('index_page');
Route::post('/index/indexsend', [EnterUserRecordController::class, 'indexsend' ])->name('indexsend');

Route::get('/login', [EnterUserRecordController::class, 'login'])->name('login_page_view');
Route::post('/', [EnterUserRecordController::class, 'loginsend'])->name('loginsend');

Route::get('/loginview', [EnterUserRecordController::class, 'loginview_page'])->name('login_page');

// 
Route::get('/post', [PostDataController::class, 'post'])->name('post_page');
// Route::get('/post/{userId}', [PostDataController::class, 'post'])->name('post_page');

Route::post('/post', [PostDataController::class, 'post_fun'])->name('post_fun');
// Route::post('/post/{userId}', [PostDataController::class, 'post_fun'])->name('post_fun');
// Route::get('/posts', [PostController::class, 'showPosts'])->name('posts.index');

// google api
Route::get('googleLogin', [EnterUserRecordController::class, 'googleLogin'])->name('google');
Route::get('login/google/callback', [EnterUserRecordController::class, 'googleHandle'])->name('google_page');


Route::get('/', function () { return view('welcome'); });