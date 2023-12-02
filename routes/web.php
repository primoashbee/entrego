<?php

use App\Models\User;
use App\Models\ManPower;
use App\Services\Semaphore;
use App\Mail\JobAppliedMail;
use Illuminate\Http\Request;
use App\Models\JobApplication;
use App\Models\UserJobApplication;
use App\Mail\ManPowerRequestChanged;
use Illuminate\Support\Facades\Route;
use App\Models\UserPersonalAssessment;
use App\Mail\PersonalAssessmentDueMail;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\V2QuizController;
use App\Http\Middleware\IsAdminMiddleware;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\ManPowerController;
use App\Http\Controllers\UserQuizController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\V2UserQuizController;
use App\Http\Controllers\GeneratePDFController;
use App\Http\Middleware\ApplicanTakenAssessment;
use App\Http\Middleware\ApplicantTakenAssessment;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\UserRequirementController;
use App\Http\Controllers\PersonalAssementController;
use App\Http\Controllers\ReportController;
use App\Http\Middleware\ApplicantHasFinishedProfile;
use App\Http\Middleware\UserPacketDownloadMiddleware;
use App\Http\Controllers\UserPersonalAssessmentController;
use App\Mail\JobInterviewMail;
use App\Mail\JobOfferMail;

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

Route::middleware(['auth', 'verified', ApplicantHasFinishedProfile::class, ApplicantTakenAssessment::class])->group(function () {


    Route::group(['prefix'=>'users', 'middleware' => [IsAdminMiddleware::class]], function(){
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/{type}/', [UserController::class, 'indexType'])->name('users.index.type');
        Route::get('/create', [UserController::class, 'createUser'])->name('users.create');
        Route::post('/create', [UserController::class, 'storeUser'])->name('users.store');
        Route::get('/update/{id}', [UserController::class, 'editUser'])->name('users.edit');
        Route::post('/update/{id}', [UserController::class, 'updateUser'])->name('users.update');
        Route::patch('/update/{id}', [UserController::class, 'patch'])->name('profile.patch');

    });
       Route::prefix('applicants')->group(function(){
        Route::get('/', [UserController::class, 'applicants'])->name('applicants.index');
    });

    Route::prefix('manpower')->group(function(){
        Route::get('/', [ManPowerController::class, 'index'])->name('manpower.index');
        Route::get('/create', [ManPowerController::class, 'create'])->name('manpower.create');
        Route::post('/create', [ManPowerController::class, 'store'])->name('manpower.store');

        Route::delete('/{id}', [ManPowerController::class, 'delete'])->name('manpower.delete');
        Route::patch('/{id}', [ManPowerController::class, 'patch'])->name('manpower.patch');

        Route::get('/{id}', [ManPowerController::class, 'edit'])->name('manpower.edit');
        Route::put('/{id}', [ManPowerController::class, 'update'])->name('manpower.update');

        Route::get('/{id}/{status}', [ManPowerController::class, 'statusList'])->name('manpower.list.status');
    });

    Route::prefix('quiz')->group(function(){
        Route::get('/', [QuizController::class, 'index'])->name('quiz.index');
        Route::get('/create', [QuizController::class, 'create'])->name('quiz.create');
        Route::post('/create', [QuizController::class, 'store'])->name('quiz.store');
        Route::get('/update/{id}', [QuizController::class, 'edit'])->name('quiz.edit');
        Route::put('/update/{id}', [QuizController::class, 'update'])->name('quiz.update');

    });



    Route::prefix('/personal-assessments')->group(function(){
        Route::get('/', [PersonalAssementController::class, 'index'])->name('personal-assessments.index');
        Route::get('/{batch_id}', [PersonalAssementController::class, 'show'])->name('personal-assessments.show');

    });
});


// Open routes soon for auth
Route::middleware(['auth'])->group(function () {

    Route::get('/personal-assessment/take', [UserPersonalAssessmentController::class, 'create'])->name('personal-assessments.create');
    Route::post('/personal-assessment/take', [UserPersonalAssessmentController::class, 'store'])->name("personal-assessments.store");
    Route::get('/personal-assessment/result/{batch_id}', [UserPersonalAssessmentController::class, 'view'])->name("personal-assessments.view");
    Route::get('/profile', [UserController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [UserController::class, 'update'])->name('profile.update');

    Route::get('/jobs', [JobApplicationController::class, 'viewApplicants'])->name('user-job.index');
    Route::get('/job/{id}', [JobApplicationController::class, 'show'])->name('user-job.show');
    Route::get('/jobs/report', [JobApplicationController::class, 'viewReport'])->name('user-job.report');

    Route::post('/job/send-interview/{id}', [JobApplicationController::class, 'sendInterview'])->name('user-job.send-interview');
    Route::patch('/job/{id}', [JobApplicationController::class, 'patch'])->name('user-job.patch'); // set status

    Route::get('/user-quiz/take/{application_id}', [UserQuizController::class, 'create'])->name('user-quiz.take');
    Route::post('/user-quiz/take', [UserQuizController::class, 'store'])->name('user-quiz.submit');
    Route::get('/user-quiz/result/{application_id}', [UserQuizController::class, 'view'])->name('user-quiz.view-result');
    Route::patch('/user-quiz/result/{application_id}', [UserQuizController::class, 'patch'])->name('user-quiz.view-result.patch');

    Route::get('/download/{user_id}', [UserController::class, 'downloadCV'])->name('download.cv');
    Route::get('/download/requirement/{user_id}', [UserRequirementController::class, 'download'])->name('requirement.download');

    Route::group(['prefix'=>'/requirement', 'middleware'=> [IsAdminMiddleware::class]], function(){
        Route::get("/", [UserRequirementController::class, 'index'])->name("requirements.index");
        Route::patch("/{id}", [UserRequirementController::class, 'patch'])->name("requirements.patch");
    });

    Route::get('/user-dashboard', [DashboardController::class,'index'])->name('user.dashboard');

    Route::get('/audit', [AuditLogController::class, 'index'])->name('audit.index');

    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::get('/settings/create/{type}', [SettingController::class, 'create'])->name('settings.create');
    Route::post('/settings/create/{type}', [SettingController::class, 'store'])->name('settings.store');
    Route::get('/settings/{type}/{id}', [SettingController::class, 'edit'])->name('settings.edit');
    Route::patch('/settings/{type}/{id}', [SettingController::class, 'patch'])->name('settings.patch');
    Route::delete('/settings/{type}/{id}', [SettingController::class, 'delete'])->name('settings.delete');

    Route::prefix('v2/quiz')->group(function(){
        Route::get('/', [V2QuizController::class, 'index'])->name('v2.quiz.index');
        Route::get('/create', [V2QuizController::class, 'create'])->name('v2.quiz.create');
        Route::post('/create', [V2QuizController::class, 'store'])->name('v2.quiz.store');
        Route::get('/update/{id}', [V2QuizController::class, 'edit'])->name('v2.quiz.edit');
        Route::put('/update/{id}', [V2QuizController::class, 'update'])->name('v2.quiz.update');

    });
    Route::prefix('v2/user-quiz')->group(function(){
        Route::get('/take/{application_id}', [V2UserQuizController::class, 'create'])->name('v2.user-quiz.take');
        Route::post('/take', [V2UserQuizController::class, 'store'])->name('v2.user-quiz.submit');
        Route::get('/result/{application_id}', [V2UserQuizController::class, 'view'])->name('v2.user-quiz.view-result');
    
    });

    Route::get('/report/{type}', [ReportController::class,'index'])->name('report.index');




});

// Route::get('/view-mail/{application_id}', function(Request $request, $application_id){
//     return new JobAppliedMail(UserJobApplication::find($application_id));
// }); 


Route::get('/user/packet/{id}', [GeneratePDFController::class, 'index'])->middleware([UserPacketDownloadMiddleware::class])->name('user.download.packet');
Route::get('/pdf/profile/{id}', [UserController::class, 'pdfReport'])->name('pdf.report');
Route::get('/img/{id}', [PersonalAssementController::class, 'imgReport'])->name('assessment.img');
Route::get('/sc/{id}', [PersonalAssementController::class, 'sc']);

Route::get('/dashboard', function () {
    if(auth()->user()->role == User::APPLICANT){
        return redirect()->route('profile.edit');
    }
    // return redirect()->route('landing.page');
    return view('dashboard');
})->name('dashboard');


Route::get('/view-jobs', [JobApplicationController::class, 'index'])->name('job.listing');
Route::get('/job/apply/{id}', [JobApplicationController::class, 'create'])->name('job.create');
// Route::get('/job/applyv2/{id}', [JobApplicationController::class, 'createv2'])->name('job.create');
Route::post('/job/apply/{id}', [JobApplicationController::class, 'store'])->name('job.store');


Route::get('/', [HomeController::class, 'index'])->name('landing.page');
Route::get('/full', function(){
    return view('test-master');
}); 

Route::get('/test-sms', function(){
    $client=  new Semaphore('1234');
});
Route::get('/test', function(){
    return view('test');
});

Route::get('/itest', function(){
    $j = UserJobApplication::find(8);
    return new JobOfferMail($j);
});
require __DIR__.'/auth.php';
