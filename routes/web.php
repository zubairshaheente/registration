<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Verification;
use App\Http\Controllers\EditUserRecord;
use App\Http\Controllers\PostDataController;
use App\http\Controllers\EnterUserRecordController;
use App\http\Controllers\SmsController;

Route::get('/index', [EnterUserRecordController::class, 'index' ])->name('index_page');
Route::post('/login', [EnterUserRecordController::class, 'indexsend' ])->name('indexsend');

// for sending email verification
Route::get('/verify/{token}', [EnterUserRecordController::class, 'verify'])->name('verify');

// For Resend Verify Email
Route::get('resend_verify_email', [EnterUserRecordController::class, 'verify_email'])->name('verify_email');
Route::post('/resend_verify_email', [EnterUserRecordController::class, 'resend_verification_email'])->name('resend_verification_email');

// Login
Route::get('/login', [EnterUserRecordController::class, 'login'])->name('login');
Route::post('/', [EnterUserRecordController::class, 'loginsend'])->name('loginsend');

// Post
Route::get('/index', [PostDataController::class, 'index'])->name('index')->middleware('auth');
Route::post('/posts/create', [PostDataController::class, 'create'])->name('create')->middleware('auth');

// Edit User Profile
Route::get('/editprofile', [EditUserRecord::class, 'edit_rec'])->name('editprofile')->middleware('auth');
Route::post('/editprofile', [EditUserRecord::class, 'edit_user_rec'])->name('edit_user_rec')->middleware('auth');

// Logout
Route::get('/signout', [EnterUserRecordController::class, 'signout'])->name('signout');

Route::get('/', function () { return view('welcome'); });

// google api
Route::get('googleLogin', [EnterUserRecordController::class, 'googleLogin'])->name('google');
Route::get('login/google/callback', [EnterUserRecordController::class, 'googleHandle'])->name('google_page');

// auto create using jetstream cmd for Facebook Authantication
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
    Route::get('/dashboard', function () { return view('dashboard');
    })->name('dashboard');
});

// FB
route::get('auth/facebook', [EnterUserRecordController::class, 'facebookpage'])->name('facebook');
route::get('auth/facebook/callback', [EnterUserRecordController::class, 'facebookredirect'])->name('facebookredirect');

