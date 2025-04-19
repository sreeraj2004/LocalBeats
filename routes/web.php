<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\AuthController;
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
Route::post('/register/user', [AuthController::class, 'registerUser']);
Route::post('/register/musician', [AuthController::class, 'registerMusician']);
Route::post('/login/user', [AuthController::class, 'login']);
Route::post('/login/musician', [AuthController::class, 'login']);

