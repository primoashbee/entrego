<?php

use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobApplicationController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ManPowerController;
use App\Http\Controllers\UserQuizController;
use App\Http\Middleware\ApplicanTakenAssessment;
use App\Http\Middleware\ApplicantTakenAssessment;
use App\Http\Controllers\PersonalAssementController;
use App\Http\Middleware\ApplicantHasFinishedProfile;
use App\Http\Controllers\UserPersonalAssessmentController;
use App\Http\Controllers\UserRequirementController;
use App\Http\Middleware\IsAdminMiddleware;
use App\Models\JobApplication;
use App\Models\UserJobApplication;
use App\Models\UserPersonalAssessment;
use App\Services\Semaphore;

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
        Route::get('/create', [UserController::class, 'createUser'])->name('users.create');
        Route::post('/create', [UserController::class, 'storeUser'])->name('users.store');
        Route::get('/update/{id}', [UserController::class, 'editUser'])->name('users.edit');
        Route::post('/update/{id}', [UserController::class, 'updateUser'])->name('users.update');
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

    Route::post('/job/send-interview/{id}', [JobApplicationController::class, 'sendInterview'])->name('user-job.send-interview');
    Route::patch('/job/{id}', [JobApplicationController::class, 'patch'])->name('user-job.patch'); // set status

    Route::get('/user-quiz/take/{application_id}', [UserQuizController::class, 'create'])->name('user-quiz.take');
    Route::post('/user-quiz/take', [UserQuizController::class, 'store'])->name('user-quiz.submit');
    Route::get('/user-quiz/result/{application_id}', [UserQuizController::class, 'view'])->name('user-quiz.view-result');

    Route::get('/download/{user_id}', [UserController::class, 'downloadCV'])->name('download.cv');
    Route::get('/download/requirement/{user_id}', [UserRequirementController::class, 'download'])->name('requirement.download');

    Route::prefix('/requirement')->group(function(){
        Route::get("/", [UserRequirementController::class, 'index'])->name("requirements.index");
        Route::patch("/{id}", [UserRequirementController::class, 'patch'])->name("requirements.patch");
    });

    Route::get('/user-dashboard', [DashboardController::class,'index'])->name('user.dashboard');

    Route::get('/audit', [AuditLogController::class, 'index'])->name('audit.index');


});

Route::get('/dashboard', function () {
    if(auth()->user()->role == User::APPLICANT){
        return redirect()->route('profile.edit');
    }
    // return redirect()->route('landing.page');
    return view('dashboard');
})->name('dashboard');


Route::get('/view-jobs', [JobApplicationController::class, 'index'])->name('job.listing');
Route::get('/job/apply/{id}', [JobApplicationController::class, 'create'])->name('job.create');
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
    $j = UserJobApplication::first();
    return new \App\Mail\JobInterviewMail($j);
});
require __DIR__.'/auth.php';
