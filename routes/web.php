<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\TokenVerificationMiddleWare;

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

Route::get('/', function () {
    return view('welcome');
});

Route::post('/user-registration', [UserController::class, 'UserRegistration']);
Route::post('/user-login', [UserController::class, 'UserLogin']);
Route::post('/send-otp', [UserController::class,'sendOtoMail']);
Route::post('/verify-otp', [UserController::class,'verifyOtp']);
Route::post('/reset-password', [UserController::class,'resetPassword'])->middleware([TokenVerificationMiddleWare::class]);

Route::view('/dashboard', 'backend/index');

