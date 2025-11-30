<?php

use App\Http\Controllers\AnnouncementController;
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



Route::middleware(['auth', 'role:resident'])->group(function(){
    Route::prefix('resident')->name('resident.')->group(function(){
        Route::get('/dashboard', [ResidentController::class,'dashboard'])->name('dashboard');
        Route::get('/profile', [ResidentController::class,'profile'])->name('profile');
        Route::get('/blotter', [ResidentController::class,'blotter'])->name('blotter');
        Route::get('/certificate', [ResidentController::class,'certificate'])->name('certificate');
        Route::get('/clearance', [ResidentController::class,'clearance'])->name('clearance');
        Route::get('/service', [ResidentController::class,'service'])->name('service');
        Route::get('/complaint', [ResidentController::class,'complaint'])->name('complaint');
        Route::get('/feedback', [ResidentController::class,'feedback'])->name('feedback');
        Route::get('/aboutus', [ResidentController::class,'aboutus'])->name('aboutus');
        Route::get('/contactus', [ResidentController::class,'contactus'])->name('contactus');
    });
});

Route::middleware(['auth', 'role:admin'])->group(function(){
    Route::prefix('admin')->name("admin.")->group(function(){
        Route::get('/dashboard', [ResidentController::class,'dashboard'])->name('dashboard');
        Route::get('/profile', [ResidentController::class,'profile'])->name('profile');
        Route::get('/blotter', [ResidentController::class,'blotter'])->name('blotter');
        Route::get('/certificate', [ResidentController::class,'certificate'])->name('certificate');
        Route::get('/clearance', [ResidentController::class,'clearance'])->name('clearance');
        Route::get('/service', [ResidentController::class,'service'])->name('service');
        Route::get('/complaint', [ResidentController::class,'complaint'])->name('complaint');
        Route::get('/feedback', [ResidentController::class,'feedback'])->name('feedback');
        Route::get('/aboutus', [ResidentController::class,'aboutus'])->name('aboutus');
        Route::get('/contactus', [ResidentController::class,'contactus'])->name('contactus');

        Route::get('/create-announcement', [AnnouncementController::class, 'showAnnouncementForm'])->name('showAnnouncements');
        Route::post('/create-announcement', [AnnouncementController::class, 'createAnnouncement'])->name('submit.announcement');
    });
});


