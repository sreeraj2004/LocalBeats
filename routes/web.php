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



Route::get('/' , [MusicController::class, 'index']);
Route::get('/home', [MusicController::class, 'index'])->name('home');
Route::get('/musicians', [MusicController::class, 'musicians'])->name('musicians');
Route::get('/events', [MusicController::class, 'events'])->name('events');
Route::get('/music', [MusicController::class, 'music'])->name('music');
Route::get('/about', [MusicController::class, 'about'])->name('about');
Route::post('/register/user', [AuthController::class, 'registerUser']);
Route::post('/register/musician', [AuthController::class, 'registerMusician']);
Route::post('/login/user', [AuthController::class, 'login']);
Route::post('/login/musician', [AuthController::class, 'login']);
Route::post('/upload-music', [UploadController::class, 'uploadMusic']);
Route::post('/upload-event', [UploadController::class, 'uploadEvent']);

