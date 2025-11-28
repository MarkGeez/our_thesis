<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ResidentController;

use Illuminate\Support\Facades\Route;


use App\Http\Middleware\secret;
use Illuminate\Auth\Events\Login;

Route::get('/', function () {
    return view('welcome');
});


Route::get('login', [AuthController::class,'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.attempt');

Route::get('register', [RegistrationController::class,'showRegister'])->name('register');
Route::post('register', [RegistrationController::class, 'register'])->name('register.attempt');


Route::get('/', function () {
    return view('index'); 
});



Route::middleware(['auth', 'role.redirect'])->group(function(){
    Route::prefix('/resident/{id}')->group(function(){
        Route::get('/dashboard', [ResidentController::class,'dashboard'])->name(name: 'resident.dashboard');
        Route::get('/profile', [ResidentController::class,'profile'])->name(name: 'resident.profile');
        Route::get('/announcement', [ResidentController::class,'announcement'])->name(name: 'resident.announcement');
        Route::get('/blotter', [ResidentController::class,'blotter'])->name(name: 'resident.blotter');
        Route::get('/certificate', [ResidentController::class,'certificate'])->name(name: 'resident.certificate');
        Route::get('/clearance', [ResidentController::class,'clearance'])->name(name: 'resident.clearance');
        Route::get('/service', [ResidentController::class,'service'])->name(name: 'resident.service');
        Route::get('/complaint', [ResidentController::class,'complaint'])->name(name: 'resident.complaint');
        Route::get('/feedback', [ResidentController::class,'feedback'])->name(name: 'resident.feedback');

        Route::get('/aboutus', [ResidentController::class,'aboutus'])->name(name: 'resident.aboutus');
        Route::get('/contactus', [ResidentController::class,'contactus'])->name(name: 'resident.contactus');





    });

});