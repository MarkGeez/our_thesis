<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ResidentController;
use App\Http\Middleware\secret;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('login', [AuthController::class,'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.attempt');

Route::get('register', [RegistrationController::class,'showRegister'])->name('register');
Route::post('register', [RegistrationController::class, 'register'])->name('register.attempt');







Route::middleware(['auth', 'role.redirect'])->group(function(){
    Route::prefix('/resident/{id}')->group(function(){
        Route::get('/dashboard', [ResidentController::class,'dashboard'])->name(name: 'resident.dashboard');
        Route::get('/blotter', [ResidentController::class,'blotter'])->name(name: 'resident.blotter');
        Route::get('/blotter', [ResidentController::class,'blotter'])->name(name: 'resident.blotter');

    });

});