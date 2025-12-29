<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\SubAdminController;
use App\Http\Controllers\ActiveLogController;
use App\Http\Controllers\BlotterController;

use App\Http\Controllers\NonResidentController;

use Illuminate\Support\Facades\Route;


use Illuminate\Auth\Events\Login;




Route::get('login', [AuthController::class,'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('register', [RegistrationController::class,'showRegister'])->name('register');
Route::post('register', [RegistrationController::class, 'register'])->name('register.attempt');


Route::get('/', function () {
    return view('index'); 
});



// Resident Routes
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
        Route::post('/feedback', [FeedbackController::class, 'submitFeedback'])->name('submit.feedback');
        Route::get('/aboutus', [ResidentController::class,'aboutus'])->name('aboutus');
        Route::get('/contactus', [ResidentController::class,'contactus'])->name('contactus');
        Route::post('/complaint', [ComplaintController::class, 'submitComplaint'])->name('submit.complaint');
        
    });
});


Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class,'dashboard'])->name('dashboard');
    Route::get('/profile', [AdminController::class,'profile'])->name('profile');

    Route::get('/blotterRequest', [AdminController::class,'blotterRequest'])->name('blotterRequest');
    Route::post('/blotterRequest', [BlotterController::class, 'submitBlotter'])->name('submit.blotter');
    Route::put('/blotterRequest/update/{id}', [BlotterController::class, 'updateBlotter'])->name('update.blotter');
    Route::put('/blotterRequest/status/{id}', [BlotterController::class, 'updateStatus'])->name('status.blotter');


    Route::get('/certificateRequest', [AdminController::class,'certificateRequest'])->name('certificateRequest');
    Route::get('/clearanceRequest', [AdminController::class,'clearanceRequest'])->name('clearanceRequest');
    Route::get('/serviceRequest', [AdminController::class,'serviceRequest'])->name('serviceRequest');

    Route::get('/complaintRequest', [ComplaintController::class,'showComplaints'])->name('complaintRequest');
    Route::put('/complaintRequest/{id}', [ComplaintController::class, 'updateStatus'])->name('update.complaint');
    Route::get('/adminComplaint', [AdminController::class,'adminComplaint'])->name('adminComplaint');
    Route::post('/adminComplaint', [ComplaintController::class, 'submitComplaint'])->name('submit.complaint');

    Route::get('/feedbackRequest', [AdminController::class,'feedbackRequest'])->name('feedbackRequest');
    Route::get('/aboutus', [AdminController::class,'aboutus'])->name('aboutus');
    Route::get('/contactus', [AdminController::class,'contactus'])->name('contactus');
    Route::get('/settings', [AdminController::class,'settings'])->name('settings');
    Route::get('/barangayOfficials', [AdminController::class,'barangayOfficials'])->name('barangayOfficials');
    Route::get('/census', [AdminController::class,'census'])->name('census');
    Route::get('/users', [AdminController::class,'users'])->name('users');

    // Use ActiveLogController here and avoid double "admin" in the path
    Route::get('/activityLogs', [ActiveLogController::class, 'logs'])->name('activityLogs');

    Route::get('/reports', [AdminController::class,'reports'])->name('reports');
    Route::get('/adminBlotter', [AdminController::class,'adminBlotter'])->name('adminBlotter');
    Route::get('/adminCertificate', [AdminController::class,'adminCertificate'])->name('adminCertificate');
    Route::get('/adminServices', [AdminController::class,'adminServices'])->name('adminServices');
    Route::get('/announcements', [AdminController::class, 'announcements'])->name('announcements');
    Route::get('/archives', [ArchiveController::class,'showArchive'])->name('archives');
    Route::get('/create-announcement', [AnnouncementController::class, 'showAnnouncementForm'])->name('create-announcement');
    Route::post('/create-announcement', [AnnouncementController::class, 'createAnnouncement'])->name('submit.announcement');
    Route::get('/edit-announcement/{id}', [AnnouncementController::class, 'showEdit'])->name('editAnnouncement');
    Route::put('/edit-announcement/{id}', [AnnouncementController::class, 'update'])->name('update.announcement');
    Route::delete('/archive-announcement/{id}', [AnnouncementController::class, 'archive'])->name('announcement.archive');


});

Route::middleware(['auth', 'role:subadmin'])->group(function(){
    Route::prefix('subadmin')->name("subadmin.")->group(function(){
        Route::get('/dashboard', [SubAdminController::class,'dashboard'])->name('dashboard');
        Route::get('/profile', [SubAdminController::class,'profile'])->name('profile');
        Route::get('/blotterRequest', [SubAdminController::class,'blotterRequest'])->name('blotterRequest');
        Route::get('/adminBlotter', [SubAdminController::class,'adminBlotter'])->name('adminBlotter');
        Route::get('/adminCertificate', [SubAdminController::class,'adminCertificate'])->name('adminCertificate');
        Route::get('/adminServices', [SubAdminController::class,'adminServices'])->name('adminServices');
        Route::get('/adminComplaint', [SubAdminController::class,'adminComplaint'])->name('adminComplaint');
        Route::get('/announcements', [SubAdminController::class,'announcements'])->name('announcements');
       
        Route::get('/complaintRequest', [SubAdminController::class,'complaintRequest'])->name('complaintRequest');
        Route::put('/complaintRequest/{id}', [SubAdminController::class, 'updateComplaint'])->name('update.complaint');



        Route::get('/certificateRequest', [SubAdminController::class,'certificateRequest'])->name('certificateRequest');
        Route::get('/clearanceRequest', [SubAdminController::class,'clearanceRequest'])->name('clearanceRequest');
        Route::get('/serviceRequest', [SubAdminController::class,'serviceRequest'])->name('serviceRequest');
        

        Route::post('/complaint', [ComplaintController::class, 'submitComplaint'])->name('submit.complaint');


         Route::get('/create-announcement', [AnnouncementController::class, 'showAnnouncementForm'])->name('create-announcement.form');
    Route::post('/create-announcement', [AnnouncementController::class, 'createAnnouncement'])->name('create-announcement');
    
    Route::get('/edit-announcement/{id}', [AnnouncementController::class, 'showEdit'])->name('editAnnouncement');
    Route::put('/edit-announcement/{id}', [AnnouncementController::class, 'update'])->name('update.announcement');
    Route::delete('/archive-announcement/{id}', [AnnouncementController::class, 'archive'])->name('announcement.archive');
    
    });
});


// Nonresident routes
Route::middleware(['auth', 'role:non-resident'])->group(function(){
    Route::prefix('non-resident')->name('non-resident.')->group(function(){
        Route::get('/dashboard', [NonResidentController::class,'dashboard'])->name('dashboard');
        Route::get('/profile', [NonResidentController::class,'profile'])->name('profile');
        Route::get('/blotter', [NonResidentController::class,'blotter'])->name('blotter');
        Route::get('/aboutus', [NonResidentController::class,'aboutus'])->name('aboutus');
        Route::get('/contactus', [NonResidentController::class,'contactus'])->name('contactus');
        
    });
});


