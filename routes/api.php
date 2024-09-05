<?php

use App\Http\Controllers\ClassPaperController;
use App\Http\Controllers\ClassTuteController;
use App\Http\Controllers\PaymentCategoryController;
use App\Http\Controllers\ReceiptCategoryController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\IncomeTaxPaymentController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\NotePaperController;
use App\Http\Controllers\ScheduledLessonController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\StudentAttendenceController;
use App\Http\Controllers\StudentCertificateController;
use App\Http\Controllers\StudenttermTestController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TaxPaymentController;
use App\Http\Controllers\VideoRecordController;
use App\Models\Lesson;
use App\Models\StudentCertificate;
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
    Route::get('/student-subject', [SubjectController::class, 'studentSubjects']);
    Route::get('/student-subject-term', [SubjectController::class, 'studentSubjectsTerm']);

    Route::get('/student-certificate', [StudentCertificateController::class, 'studentCertificate']);
    Route::post('/student-certificate-upload', [StudentCertificateController::class, 'studentCertificateUpload']);

    Route::post('/attendence', [StudentAttendenceController::class, 'StudentAttendence']);
    Route::get('/student-attendances-data', [StudentAttendenceController::class, 'StudentAttendenceData']);
    

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

    Route::get('/class-tute-books', [ClassTuteController::class, 'index']);


    Route::get('/class-tutes-teacher', [ClassTuteController::class, 'Teacherindex']);
    Route::post('/class-tutes-store', [ClassTuteController::class, 'TeacherStore']);
    Route::delete('/class-tutes-destroy/{id}', [ClassTuteController::class, 'TeacherDestroy']);


    Route::get('/class-papers-teacher', [ClassPaperController::class, 'Teacherindex']);
    Route::post('/class-papers-store', [ClassPaperController::class, 'TeacherStore']);
    Route::delete('/class-papers-destroy/{id}', [ClassPaperController::class, 'TeacherDestroy']);

    
    

    Route::post('auto-schedule', [LessonController::class, 'autoSchedule']);
    Route::post('/send-sms', [SmsController::class, 'loginAndSendSms']);



    Route::get('/teacher-subject', [SubjectController::class, 'TeacherSubjects']);


    Route::get('class-notes-list-teacher', [NotePaperController::class, 'index']);
    Route::get('class-notes-count', [NotePaperController::class, 'ClassNotecount']);
    Route::post('class-notes-store', [NotePaperController::class, 'store']);
    Route::put('class-notes-update/{notePaper}', [NotePaperController::class, 'update']);
    Route::delete('class-notes-destroy/{notePaper}', [NotePaperController::class, 'destroy']);
    Route::get('/class-notes-list', [NotePaperController::class, 'Studentindex']);

    Route::post('/class-notes-upload', [NotePaperController::class, 'Noteupload']);


    Route::get('/class-papers', [ClassPaperController::class, 'index']);

    Route::post('/term-test-upload', [StudenttermTestController::class, 'store']);


    Route::get('/student-subjects-grade-related', [SubjectController::class, 'studentSubjectGradeRelated']);



    route::get('/single-grade', [GradeController::class, 'singleGrade']);
    route::get('/single-subject', [SubjectController::class, 'singleSubject']);
    
}); 

//Route::resource('/subjects', [SubjectController::class, 'index'])->middleware('check.apikey');