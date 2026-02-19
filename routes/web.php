<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\SubAdminController;
use App\Http\Controllers\ActiveLogController;
use App\Http\Controllers\BlotterController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\ResidentListController;
use App\Http\Controllers\UserListController;
use App\Http\Controllers\OfficialController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\HouseholdController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ReportsController;



use App\Http\Controllers\NonResidentController;

use Illuminate\Support\Facades\Route;


use Illuminate\Auth\Events\Login;




Route::get('login', [AuthController::class,'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('register', [RegistrationController::class,'showRegister'])->name('register');
Route::post('register', [RegistrationController::class, 'register'])->name('register.attempt');

// Password Reset Routes
Route::get('/password/forgot', [PasswordResetController::class, 'showForgotForm'])->name('password.request');
Route::post('/password/email', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
Route::get('/password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/update', [PasswordResetController::class, 'updatePassword'])->name('password.update');

Route::get('/', [LandingController::class, 'display']);



// Resident Routes
Route::middleware(['auth', 'role:resident'])->group(function(){
    Route::prefix('resident')->name('resident.')->group(function(){
        Route::get('/dashboard', [ResidentController::class,'dashboard'])->name('dashboard');
        Route::get('/profile', [ResidentController::class,'profile'])->name('profile');
        Route::put('/profile/update/{id}', [UserListController::class, 'updateProfile'])->name('update.profile');
        Route::put('/profile/{id}', [ResidentListController::class, 'updateOwnInfo'])->name('update.ownInfo');
        Route::get('add-member', [ResidentController::class, 'search']);


        Route::get('/profile/add-family', function () {
            return view('profileforms.addMemberPage');
        })->name('family.add');
        Route::post('/profile/add-family', [HouseholdController::class, 'storeFamilyMember'])->name('family.store');
   Route::delete('profile/delete-family/{id}', [HouseholdController::class, 'untagMember'])->name('untag.member');
    Route::put('profile/update-family/{id}', [HouseholdController::class, 'editMember'])->name('edit.family');


        Route::get('/blotter', [BlotterController::class, 'ownBlotters'])->name('Blotter');

        Route::get('/certificate', [ResidentController::class,'certificate'])->name('certificate');
        Route::post('/certificate/request', [CertificateController::class, 'store'])->name('certificate.request.store');
        Route::get('/clearance', [ResidentController::class,'clearance'])->name('clearance');
        Route::get('/service', [ServiceController::class,'residentIndex'])->name('service');
        Route::post('/service/request', [ServiceRequestController::class, 'store'])->name('service.request.store');
        Route::get('/complaint', [ResidentController::class,'complaint'])->name('complaint');
        Route::get('/feedback', [ResidentController::class,'feedback'])->name('feedback');
        Route::post('/feedback', [FeedbackController::class, 'submitFeedback'])->name('submit.feedback');
        Route::get('/aboutus', [ResidentController::class,'aboutus'])->name('aboutus');
        Route::get('/contactus', [ResidentController::class,'contactus'])->name('contactus');
        Route::post('/complaint', [ComplaintController::class, 'submitComplaint'])->name('submit.complaint');
        
        // check mo kung tama to nagana naman sa side ko
        Route::post('/blotterRequest', [BlotterController::class, 'submitBlotter'])->name('submit.blotter');
        Route::put('/blotterRequest/update/{id}', [BlotterController::class, 'updateBlotter'])->name('update.blotter');
        Route::put('/blotterRequest/status/{id}', [BlotterController::class, 'updateStatus'])->name('status.blotter');
        
    });
});


Route::prefix('admin/blotter')
    ->name('admin.blotter.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        // List blotters
        Route::get('/', [BlotterController::class, 'index'])
            ->name('index');
        // Show create form
        Route::get('/create', [BlotterController::class, 'create'])
            ->name('create');
        // Store new blotter
        Route::post('/', [BlotterController::class, 'submitBlotter'])
            ->name('store');
        // Show update form - Use different URI pattern
        Route::get('/{id}/edit', [BlotterController::class, 'showUpdateForm'])
            ->name('update.form');
        // Store new update (append-only) - Use different method and URI
        Route::put('/{id}/updates', [BlotterController::class, 'storeUpdate'])
            ->name('update.store');
    });


Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class,'dashboard'])->name('dashboard');
    Route::get('/profile', [AdminController::class,'profile'])->name('profile');
    Route::get('/profile/add-family', function () {
        return view('profileforms.addMemberPage');
    })->name('family.add');
    Route::put('/profile/{id}', [ResidentListController::class, 'updateOwnInfo'])->name('update.ownInfo');
    Route::put('/profile/update/{id}', [UserListController::class, 'updateProfile'])->name('update.profile');

    //HOUSE HOLD
    Route::post('/profile/add-family', [HouseholdController::class, 'storeFamilyMember'])->name('family.store');
    Route::get('/household-management', [HouseholdController::class, 'showHousehold'])->name('household');
    Route::get('/households/streets/{id}', [HouseholdController::class, 'showStreets'])->name('households.streets');
    Route::get('/households/houses/{id}', [HouseholdController::class, 'showHeads'])->name('households.heads');
    Route::delete('profile/delete-family/{id}', [HouseholdController::class, 'untagMember'])->name('untag.member');
    Route::put('profile/update-family/{id}', [HouseholdController::class, 'editMember'])->name('edit.family');
    Route::get('/profile/search', [HouseholdController::class, 'search']);

    //REPORTS

     Route::get('/reports', [ReportsController::class, 'index'])->name('reports.index');
    Route::post('/reports/generate/population', [ReportsController::class, 'generatePopulation'])->name('reports.population');
    Route::post('/reports/generate/blotter', [ReportsController::class, 'generateBlotter'])->name('reports.blotter');
    Route::post('/reports/generate/certificate', [ReportsController::class, 'generateCertificate'])->name('reports.certificate');
    Route::get('/reports/view/{id}', [ReportsController::class, 'view'])->name('reports.view');



    Route::get('/certificateRequest', [AdminController::class,'certificateRequest'])->name('certificateRequest');
    Route::get('/certificate-request-details/{id}', [AdminController::class, 'getCertificateRequestDetails'])->name('certificate.details');
    Route::post('/certificate/request', [CertificateController::class, 'store'])->name('certificate.request.store');
    Route::post('/certificate/approve/{id}', [CertificateController::class, 'approve'])->name('certificate.approve');
    Route::post('/certificate/reject/{id}', [CertificateController::class, 'reject'])->name('certificate.reject');
    Route::get('/certificate/preview/{id}', [CertificateController::class, 'preview'])->name('certificate.preview');
    Route::get('/certificate/generate/{id}', [CertificateController::class, 'generate'])->name('certificate.generate');
    Route::post('/certificate/print-with-data', [CertificateController::class, 'printWithData'])->name('certificate.printWithData');
    Route::get('/certificate/history/{userId}', [CertificateController::class, 'history'])->name('certificate.history');
    Route::get('/user-info/{id}', [AdminController::class, 'getUserInfo'])->name('user.info');
    Route::get('/resident-info/{id}', [AdminController::class, 'getResidentInfo'])->name('resident.info');
    Route::get('/clearanceRequest', [AdminController::class,'clearanceRequest'])->name('clearanceRequest');
    Route::get('/serviceRequest', [ServiceRequestController::class,'adminIndex'])->name('serviceRequest');
    Route::post('/service/request', [ServiceRequestController::class, 'store'])->name('service.request.store');
    Route::put('/serviceRequest/{serviceRequest}/status', [ServiceRequestController::class, 'updateStatus'])->name('serviceRequest.status');

    Route::get('/complaintRequest', [ComplaintController::class,'showComplaints'])->name('complaintRequest');
    Route::put('/complaintRequest/{id}', [ComplaintController::class, 'updateStatus'])->name('update.complaint');
    Route::get('/adminComplaint', [AdminController::class,'adminComplaint'])->name('adminComplaint');
    Route::post('/adminComplaint', [ComplaintController::class, 'submitComplaint'])->name('submit.complaint');

    Route::get('/feedbackRequest', [AdminController::class,'feedbackRequest'])->name('feedbackRequest');
    Route::get('/aboutus', [AdminController::class,'aboutus'])->name('aboutus');
    Route::get('/contactus', [AdminController::class,'contactus'])->name('contactus');
    Route::get('/settings', [AdminController::class,'settings'])->name('settings');
    Route::post('/settings', [AdminController::class,'updateSettings'])->name('updateSettings');

    Route::get('/barangayOfficials', [OfficialController::class,'displayOfficials'])->name('barangayOfficials');
    Route::post('/barangayOfficials/assign', [OfficialController::class, 'assign'])->name('assign.official');
    Route::post('/barangayOfficials/add-role', [OfficialController::class, 'createOfficialName'])->name('add.officialName');
    Route::delete('/barangayOfficials/{id}', [OfficialController::class, 'untagOfficial'])->name('untag.official');

  

    Route::get('/census', [AdminController::class,'census'])->name('census');

    Route::get('/users', [UserListController::class,'showUsers'])->name('users');
    Route::put('/users/update-role/{id}', [UserListController::class, 'updateRole'])->name('update.role');
    Route::put('/users/update-status/{id}', [UserListController::class, 'updateStatus'])->name('update.status');

    // Use ActiveLogController here and avoid double "admin" in the path
    Route::get('/activityLogs', [ActiveLogController::class, 'logs'])->name('activityLogs');

    Route::get('/adminCertificate', [AdminController::class,'adminCertificate'])->name('adminCertificate');
    Route::get( '/adminServices', [ServiceController::class,'adminIndex'])->name('adminServices');
    Route::post('/adminServices', [ServiceController::class,'store'])->name('services.store');
    Route::put('/adminServices/{service}', [ServiceController::class,'update'])->name('services.update');
    Route::delete('/adminServices/{service}/archive', [ServiceController::class,'archive'])->name('services.archive');
    Route::get('/announcements', [AdminController::class, 'announcements'])->name('announcements');
    Route::get('/archives', [ArchiveController::class,'showArchive'])->name('archives');
    
    Route::get('/create-announcement', [AnnouncementController::class, 'showAnnouncementForm'])->name('create-announcement');
    Route::post('/create-announcement', [AnnouncementController::class, 'createAnnouncement'])->name('submit.announcement');
    Route::get('/edit-announcement/{id}', [AnnouncementController::class, 'showEdit'])->name('editAnnouncement');
    Route::put('/edit-announcement/{id}', [AnnouncementController::class, 'update'])->name('update.announcement');
    Route::delete('/archive-announcement/{id}', [AnnouncementController::class, 'archive'])->name('announcement.archive');

    Route::get('/residents', [ResidentListController::class, 'showResidents'])->name('residents');
    Route::post('/residents', [ResidentListController::class, 'encodeResidents'])->name('encode.residents');
    Route::get('/residents', [ResidentListController::class, 'searchResidents'])->name('residents');
    Route::post('/residents/role/{id}', [OfficialController::class, 'addOfficial'])->name('add.official');
    Route::put('/residents/role/{id}', [OfficialController::class, 'updateOfficial'])->name('update.official');

    Route::put('/residents/{id}', [ResidentListController::class, 'updateResident'])->name('update.resident');
    Route::delete('/residents/{id}', [ResidentListController::class, 'archiveResident'])->name('archive.resident');
    

});

Route::middleware(['auth', 'role:subadmin'])->group(function(){
    Route::prefix('subadmin')->name("subadmin.")->group(function(){
        Route::get('/dashboard', [SubAdminController::class,'dashboard'])->name('dashboard');
        Route::get('/profile', [SubAdminController::class,'profile'])->name('profile');
        Route::get('/profile/add-family', function () {
            return view('profileforms.addMemberPage');
        })->name('family.add');
        Route::post('/profile/add-family', [HouseholdController::class, 'storeFamilyMember'])->name('family.store');
        Route::put('/profile/{id}', [ResidentListController::class, 'updateOwnInfo'])->name('update.ownInfo');
        Route::put('/profile/update/{id}', [UserListController::class, 'updateProfile'])->name('update.profile');
        Route::get('/blotterRequest', [SubAdminController::class,'blotterRequest'])->name('blotterRequest');
            Route::get('/subadminCertificate', [SubAdminController::class,'subadminCertificate'])->name('subadminCertificate');
        Route::get('/subadminServices', [ServiceController::class,'subadminIndex'])->name('subadminServices');
        Route::post('/subadminServices', [ServiceController::class,'store'])->name('services.store');
        Route::get('/complaint', [SubAdminController::class,'adminComplaint'])->name('complaint');
        Route::get('/announcements', [SubAdminController::class,'announcements'])->name('announcements');
       
        Route::get('/complaintRequest', [SubAdminController::class,'complaintRequest'])->name('complaintRequest');
        Route::put('/complaintRequest/{id}', [SubAdminController::class, 'updateComplaint'])->name('update.complaint');



        Route::get('/certificateRequest', [SubAdminController::class,'certificateRequest'])->name('certificateRequest');
        Route::post('/certificate/request', [CertificateController::class, 'store'])->name('certificate.request.store');
        Route::get('/clearanceRequest', [SubAdminController::class,'clearanceRequest'])->name('clearanceRequest');
        Route::get('/serviceRequest', [ServiceRequestController::class,'subadminIndex'])->name('serviceRequest');
        Route::post('/service/request', [ServiceRequestController::class, 'store'])->name('service.request.store');
        Route::put('/serviceRequest/{serviceRequest}/status', [ServiceRequestController::class, 'updateStatus'])->name('serviceRequest.status');
        

        Route::post('/complaint', [ComplaintController::class, 'submitComplaint'])->name('submit.complaint');


         Route::get('/create-announcement', [AnnouncementController::class, 'showAnnouncementForm'])->name('create-announcement.form');
    Route::post('/create-announcement', [AnnouncementController::class, 'createAnnouncement'])->name('create-announcement');
    
    Route::get('/edit-announcement/{id}', [AnnouncementController::class, 'showEdit'])->name('editAnnouncement');
    Route::put('/edit-announcement/{id}', [AnnouncementController::class, 'update'])->name('update.announcement');
    Route::delete('/archive-announcement/{id}', [AnnouncementController::class, 'archive'])->name('announcement.archive');
    
    // check mo kung tama to nagana naman sa side ko
    Route::post('/blotterRequest', [BlotterController::class, 'submitBlotter'])->name('submit.blotter');
    Route::put('/blotterRequest/update/{id}', [BlotterController::class, 'updateBlotter'])->name('update.blotter');
    Route::put('/blotterRequest/status/{id}', [BlotterController::class, 'updateStatus'])->name('status.blotter');
        
    });
});


// Nonresident routes
Route::middleware(['auth', 'role:non-resident'])->group(function(){
    Route::prefix('non-resident')->name('non-resident.')->group(function(){
        Route::get('/dashboard', [NonResidentController::class,'dashboard'])->name('dashboard');
        Route::get('/profile', [NonResidentController::class,'profile'])->name('profile');
        Route::put('/profile/update/{id}', [NonResidentController::class, 'updateProfile'])->name('update.profile');
        Route::put('/profile/{id}', [NonResidentController::class, 'updateOwnInfo'])->name('update.ownInfo');
        Route::get('/complaint', [NonResidentController::class,'complaint'])->name('complaint');
        Route::post('/complaint', [ComplaintController::class, 'submitComplaint'])->name('submit.complaint');
        Route::get('/aboutus', [NonResidentController::class,'aboutus'])->name('aboutus');
        Route::get('/contactus', [NonResidentController::class,'contactus'])->name('contactus');
        

        // check mo kung tama to nagana naman sa side ko
        Route::post('/blotterRequest', [BlotterController::class, 'submitBlotter'])->name('submit.blotter');
        Route::put('/blotterRequest/update/{id}', [BlotterController::class, 'updateBlotter'])->name('update.blotter');
        Route::put('/blotterRequest/status/{id}', [BlotterController::class, 'updateStatus'])->name('status.blotter');
        
    });
});


