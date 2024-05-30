<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\MetaphorController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfessorsController;
use App\Http\Controllers\RecordingMterialsController;
use App\Http\Controllers\SearchBookController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeachingCourseController;
use App\Http\Controllers\UniversityCityController;
use App\Models\Payment;
use App\Models\RecordingMterials;
use App\Models\TeachingCourse;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('auth/')->group(function () {

    Route::controller(StudentController::class)->prefix('student/')->group(function () {

        Route::post('register', 'register');
        Route::post('login', 'login');
        Route::post('logout', 'logout');
    });
});

Route::prefix('request/')->group(function () {

    Route::controller(UniversityCityController::class)->prefix('student/')->group(function () {

        Route::post('room', 'requestRoom')->middleware(['auth:student']);
        Route::delete('delete/room/{id}', 'deleteRoom')->middleware(['auth:student']);
        Route::post('update/status/room', 'updateStatus')->middleware(['auth:student']);
        Route::get('all/room', 'allRoom');
    });
});

Route::controller(CourseController::class)->middleware('checkRole')->prefix('couser')->group(function () {
    Route::post('add', 'addCourse');
    Route::post('update', 'update');
    Route::post('delete/{id}', 'delete');
});
Route::controller(CourseController::class)->prefix('couser')->group(function () {
    Route::post('all', 'allCourse');
});

Route::controller(ProfessorsController::class)->middleware('checkRole')->prefix('professor')->group(function () {
    Route::post('addprofessor', 'addProfessor');
    Route::post('update', 'update');
    Route::post('delete/{id}', 'delete');
});
Route::controller(ProfessorsController::class)->prefix('professor')->group(function () {
    Route::get('/all', 'allProfessors');
});
Route::controller(TeachingCourseController::class)->middleware('checkRole')->prefix('teachingCourse')->group(function () {
    Route::post('/add', 'addteach');
    Route::post('update', 'update');
    Route::post('delete/{id}', 'delete');
});
Route::controller(TeachingCourseController::class)->prefix('teachingCourse')->group(function () {
    Route::get('/all', 'allCourses');
});
Route::controller(PaymentController::class)->middleware('checkRole')->prefix('payment')->group(function () {
    Route::post('/add', 'addteach');
    Route::post('delete/{id}', 'delete');
});
Route::controller(BookController::class)->middleware('checkRole')->prefix('book')->group(function () {
    Route::post('/add', 'addBook');
    Route::post('delete/{id}', 'delete');
});
Route::controller(BookController::class)->prefix('book')->group(function () {
    Route::get('/all', 'allBook');
});
Route::controller(SearchBookController::class)->prefix('search')->group(function () {
    Route::get('/book', 'index');
});


Route::controller(MetaphorController::class)->middleware('auth:student')->prefix('metaphor')->group(function () {
    Route::post('/book', 'metaphorBook');
    Route::post('delete/{id}', 'delete');
});
Route::controller(MetaphorController::class)->prefix('metaphor')->group(function () {
    Route::get('/all', 'allMetaphor');
});

Route::controller(RecordingMterialsController::class)->middleware('auth:student')->prefix('registration')->group(function () {
    Route::post('/material', 'add');
    Route::get('/material/all', 'all');
    Route::post('delete/{id}', 'delete');
});
