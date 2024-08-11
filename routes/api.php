<?php

use App\Http\Controllers\PaymentCategoryController;
use App\Http\Controllers\ReceiptCategoryController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\IncomeTaxPaymentController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ScheduledLessonController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TaxPaymentController;
use App\Http\Controllers\VideoRecordController;
use App\Models\Lesson;
use Illuminate\Console\Scheduling\Schedule;
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
   
    Route::post('/send-otp', [SmsController::class, 'sendOTP']); // Notice the array syntax here

    Route::post('receipt-category/{id}/restore', [ReceiptCategoryController::class, 'restore'])->name('receipt-categories.restore');
    Route::resource('/receipt-category', ReceiptCategoryController::class);

    Route::post('payment-category/{id}/restore', [PaymentCategoryController::class, 'restore'])->name('payment-categories.restore');
    Route::resource('/payment-category', PaymentCategoryController::class);

    Route::post('taxpayments/{id}/restore', [TaxPaymentController::class, 'restore'])->name('taxpayments.restore');
    Route::resource('taxpayments', TaxPaymentController::class);

    Route::post('/get-subject', [SubjectController::class, 'getSubjects']);

    Route::post('incometaxpayments/{id}/restore', [IncomeTaxPaymentController::class, 'restore'])->name('incometaxpayments.restore');
    Route::resource('incometaxpayments', IncomeTaxPaymentController::class);
    
    Route::get('/live-lesson', [LessonController::class, 'index']);
    Route::get('teacher-live-lesson', [LessonController::class, 'Teacherindex']);
    Route::get('teacher-live-lesson-show', [LessonController::class, 'Lessonshow']);
    Route::post('teacher-live-lesson-update', [LessonController::class, 'Lessonupdate']);
    //Route::post('schedule-lesson', [LessonController::class, 'schedule']);
    Route::get('teacher/{teacher_id}/schedule', [LessonController::class, 'getSchedule']);
    Route::put('lesson/{id}', [LessonController::class, 'update']);
    Route::delete('lesson/{id}', [LessonController::class, 'delete']);


    Route::get('/video-recordings-teacher', [VideoRecordController::class, 'Teacherindex']);

    Route::get('/video-recordings', [VideoRecordController::class, 'index']);
    Route::put('/video-recordings/{id}', [VideoRecordController::class, 'update']);
    Route::delete('video-recordings/{id}', [VideoRecordController::class, 'delete']);

    Route::post('auto-schedule', [LessonController::class, 'autoSchedule']);
    Route::post('/send-sms', [SmsController::class, 'loginAndSendSms']);
}); 

//Route::resource('/subjects', [SubjectController::class, 'index'])->middleware('check.apikey');