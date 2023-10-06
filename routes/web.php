<?php

use App\Http\Controllers\ManPowerController;
use App\Http\Controllers\PersonalAssementController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserQuizController;
use App\Http\Middleware\ApplicantHasFinishedProfile;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth', 'verified', ApplicantHasFinishedProfile::class])->group(function () {
    Route::get('/dashboard', function () {
        return view('test-master');
    })->middleware(['auth', 'verified'])->name('dashboard');
    Route::get('/profile', [UserController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [UserController::class, 'update'])->name('profile.update');

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

    });
    Route::get('/personal-assessments', [UserQuizController::class, 'index'])->name('personals.index');
    Route::get('/quiz-pa', [PersonalAssementController::class, 'view'])->name('personals.view');

    
});
Route::get('/', function () {
    return view('welcome');
});

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });
Route::get('/full', function(){
    return view('test-master');
});
Route::get('/test', function(){
    return view('test');
});
require __DIR__.'/auth.php';
