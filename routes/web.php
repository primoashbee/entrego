<?php

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
use App\Models\JobApplication;
use App\Models\UserJobApplication;
use App\Models\UserPersonalAssessment;

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
    Route::get('/dashboard', function () {
        if(auth()->user()->role == User::APPLICANT){
            return redirect()->route('profile.edit');
        }
        return view('test-master');
    })->middleware(['auth', 'verified'])->name('dashboard');


    Route::prefix('users')->group(function(){
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

    Route::get('/user-quiz/take/{application_id}', [UserQuizController::class, 'create'])->name('user-quiz.take');
    Route::post('/user-quiz/take', [UserQuizController::class, 'store'])->name('user-quiz.submit');
    Route::get('/user-quiz/result/{application_id}', [UserQuizController::class, 'view'])->name('user-quiz.view-result');

    Route::get('/dashboard', function(){

    })->name('user.dashboard');
});

Route::get('/view-jobs', [JobApplicationController::class, 'index'])->name('job.listing');
Route::get('/job/apply/{id}', [JobApplicationController::class, 'create'])->name('job.create');
Route::post('/job/apply/{id}', [JobApplicationController::class, 'store'])->name('job.store');


Route::get('/', [HomeController::class, 'index'])->name('landing.page');
Route::get('/full', function(){
    return view('test-master');
});
Route::get('/test', function(){
    return view('test');
});
require __DIR__.'/auth.php';
