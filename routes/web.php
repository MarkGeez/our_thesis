<?php

use App\Http\Controllers\AdminController;
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
        Route::get('/dashboard', [AdminController::class,'dashboard'])->name('dashboard');
        Route::get('/profile', [AdminController::class,'profile'])->name('profile');
        Route::get('/blotterRequest', [AdminController::class,'blotterRequest'])->name('blotterRequest');
        Route::get('/certificateRequest', [AdminController::class,'certificateRequest'])->name('certificateRequest');
        Route::get('/clearanceRequest', [AdminController::class,'clearanceRequest'])->name('clearanceRequest');
        Route::get('/serviceRequest', [AdminController::class,'serviceRequest'])->name('serviceRequest');
        Route::get('/complaintRequest', [AdminController::class,'complaintRequest'])->name('complaintRequest');
        Route::get('/feedbackRequest', [AdminController::class,'feedbackRequest'])->name('feedbackRequest');
        Route::get('/aboutus', [AdminController::class,'aboutus'])->name('aboutus');
        Route::get('/contactus', [AdminController::class,'contactus'])->name('contactus');
        Route::get('/settings', [AdminController::class,'settings'])->name('settings');
        Route::get('/barangayOfficials', [AdminController::class,'barangayOfficials'])->name('barangayOfficials');
        Route::get('/census', [AdminController::class,'census'])->name('census');
        Route::get('/users', [AdminController::class,'users'])->name('users');
        Route::get('/activityLogs', [AdminController::class,'activityLogs'])->name('activityLogs');
        Route::get('/reports', [AdminController::class,'reports'])->name('reports');
        Route::get('/adminBlotter', [AdminController::class,'adminBlotter'])->name('adminBlotter');
        Route::get('/adminCertificate', [AdminController::class,'adminCertificate'])->name('adminCertificate');
        Route::get('/adminServices', [AdminController::class,'adminServices'])->name('adminServices');
        Route::get('/adminComplaint', [AdminController::class,'adminComplaint'])->name('adminComplaint');

         Route::get('/create-announcement', [AnnouncementController::class, 'showAnnouncementForm'])->name('create-announcement');
        Route::post('/create-announcement', [AnnouncementController::class, 'createAnnouncement'])->name('submit.announcement');
        Route::get('/edit-announcement/{id}', [AnnouncementController::class, 'showEdit'])->name('editAnnouncement');
        Route::put('/edit-announcement/{id}', [AnnouncementController::class, 'update'])->name('update.announcement');

       });
});


