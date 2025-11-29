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
        Route::get('/dashboard', [ResidentController::class,'dashboard'])->name(name: 'dashboard');
        Route::get('/profile', [ResidentController::class,'profile'])->name(name: 'profile');
        Route::get('/blotter', [ResidentController::class,'blotter'])->name(name: 'blotter');
        Route::get('/certificate', [ResidentController::class,'certificate'])->name(name: 'certificate');
        Route::get('/clearance', [ResidentController::class,'clearance'])->name(name: 'clearance');
        Route::get('/service', [ResidentController::class,'service'])->name(name: 'service');
        Route::get('/complaint', [ResidentController::class,'complaint'])->name(name: 'complaint');
        Route::get('/feedback', [ResidentController::class,'feedback'])->name(name: 'feedback');
        Route::get('/aboutus', [ResidentController::class,'aboutus'])->name(name: 'aboutus');
        Route::get('/contactus', [ResidentController::class,'contactus'])->name(name: 'contactus');



    });

});

Route::middleware(['auth', 'role:admin'])->group(function(){
    Route::prefix('/admin/{$id}')->group(function(){
        Route::get('/dashboard', [ResidentController::class,'dashboard'])->name(name: 'admin.dashboard');
        Route::get('/profile', action: [ResidentController::class,'profile'])->name(name: 'admin.profile');
        Route::get('/blotter', [ResidentController::class,'blotter'])->name(name: 'resident.blotter');
        Route::get('/certificate', [ResidentController::class,'certificate'])->name(name: 'admin.certificate');
        Route::get('/clearance', [ResidentController::class,'clearance'])->name(name: 'admin.clearance');
        Route::get('/service', [ResidentController::class,'service'])->name(name: 'admin.service');
        Route::get('/complaint', [ResidentController::class,'complaint'])->name(name: 'admin.complaint');
        Route::get('/feedback', [ResidentController::class,'feedback'])->name(name: 'admin.feedback');
        Route::get('/aboutus', [ResidentController::class,'aboutus'])->name(name: 'admin.aboutus');
        Route::get('/contactus', [ResidentController::class,'contactus'])->name(name: 'admin.contactus');


        Route::get('create-announcement', [AnnouncementController::class, 'showAnnouncementForm']);
        Route::post('create-announcement', action: [AnnouncementController::class, 'createAnnouncement'])->name('submit.announcement');; 

    });
});


