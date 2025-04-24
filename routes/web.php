<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UploadController;
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

// Debug route
Route::get('/debug', function () {
    return 'Debug route working';
});

// Simple test route
Route::get('/test-events', function () {
    return 'Test events route working';
});

// Simple test route
Route::get('/test-music', function () {
    return 'Test music route working';
});

// Main Routes
Route::get('/', [MusicController::class, 'index'])->name('welcome');
Route::get('/home', [MusicController::class, 'index'])->name('home');

// Public Routes
Route::get('/musicians', [MusicController::class, 'musicians'])->name('musicians');
Route::get('/musician/{id}', [MusicController::class, 'musicianDetails'])->name('musician.details');
Route::get('/tests-events', [MusicController::class, 'allEvents'])->name('tests.events');
Route::get('/tests-musics', [MusicController::class, 'allMusic'])->name('tests.musics');
Route::get('/about', [MusicController::class, 'about'])->name('about');

// Protected Musician Routes
Route::middleware(['session.auth'])->group(function () {
    Route::get('/tests-event', [MusicController::class, 'events'])->name('tests.event');
    Route::get('/tests-music', [MusicController::class, 'music'])->name('tests.music');
});

// Session-based Protected Routes
Route::post('/update-profile-photo', [UploadController::class, 'updateProfilePhoto'])->name('update.profile.photo');
Route::post('/upload-music', [UploadController::class, 'uploadMusic']);
Route::post('/upload-event', [UploadController::class, 'uploadEvent']);

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login/user', [AuthController::class, 'login'])->name('login.user');
Route::post('/login/musician', [AuthController::class, 'login'])->name('login.musician');
Route::post('/register/user', [AuthController::class, 'registerUser'])->name('register.user');
Route::post('/register/musician', [AuthController::class, 'registerMusician'])->name('register.musician');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

