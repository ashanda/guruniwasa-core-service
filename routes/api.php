<?php

use App\Http\Controllers\GradeController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\SubjectController;
use App\Models\Lesson;
use Illuminate\Http\Request;
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




Route::middleware(['check.apikey'])->group(function () {
    Route::resource('/subjects', SubjectController::class);
    Route::resource('/grades', GradeController::class);
    Route::get('/live-lesson', [LessonController::class, 'index']);
    Route::post('/send-otp', [SmsController::class, 'sendOTP']); // Notice the array syntax here
}); 

//Route::resource('/subjects', [SubjectController::class, 'index'])->middleware('check.apikey');