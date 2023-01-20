<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\UserController;
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

// for login
Route::view('/','register');
Route::post('register/user',[UserController::class,'store']);
Route::get('loginpage',[LoginController::class,'create']);
Route::post('login',[LoginController::class,'login'])->name('login');
Route::get('/logout',[LoginController::class,'logout']);

// for mail
Route::get('mailsent',[MailController::class,'send']);

Route::view('homepage', 'homepage');