<?php

use App\Http\Controllers\BirthdayController;
use App\Http\Controllers\ClassIssuesController;
use App\Http\Controllers\ClassPaperController;
use App\Http\Controllers\ClassTuteController;
use App\Http\Controllers\PaymentCategoryController;
use App\Http\Controllers\ReceiptCategoryController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\IncomeTaxPaymentController;
use App\Http\Controllers\IntroVideoController;
use App\Http\Controllers\ItemShopCategoryController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\NotePaperController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\ScheduledLessonController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\StudentAttendenceController;
use App\Http\Controllers\StudentCertificateController;
use App\Http\Controllers\StudenttermTestController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TaxPaymentController;
use App\Http\Controllers\TeacherIntroController;
use App\Http\Controllers\VideoRecIssuesController;
use App\Http\Controllers\VideoRecordController;
use App\Http\Controllers\ItemShopController;
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
    Route::get('/grade-wise-subject', [SubjectController::class, 'gradeWiseSubjects']);
    Route::post('/add-subjects', [SubjectController::class, 'CreateSubject']);
    Route::post('/update-subjects', [SubjectController::class, 'UpdateSubject']);
    Route::post('/delete-subjects', [SubjectController::class, 'DeleteSubject']);
   

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

    route::get('/student-intro', [IntroVideoController::class, 'studentIntro']);
    route::get('/teacher-intro', [IntroVideoController::class, 'teacherIntro']);
    route::get('/staff-intro', [IntroVideoController::class, 'staffIntro']);
    route::get('/admin-intro', [IntroVideoController::class, 'adminIntro']);


    Route::get('/class_issues', [ClassIssuesController::class, 'index'])->name('class.issues');
    Route::post('/store_class_issues', [ClassIssuesController::class, 'store'])->name('class.issues_store');
    Route::post('/update_store_class_issues', [ClassIssuesController::class, 'update'])->name('class.issues_update');
    Route::post('/store_class_remove', [ClassIssuesController::class, 'destroy'])->name('class.issues_remove');



    Route::get('/grade', [GradeController::class, 'index'])->name('grade'); 
    Route::post('/store_grade', [GradeController::class, 'store'])->name('grade_store');
    Route::post('/update_grade', [GradeController::class, 'update'])->name('grade_update');
    Route::post('/remove_grade', [GradeController::class, 'destroy'])->name('grade_remove');


    Route::get('/notice', [NoticeController::class, 'index'])->name('notice');
    Route::get('/notice_student', [NoticeController::class, 'indexStudent'])->name('notice_student');
    Route::get('/notice_teacher', [NoticeController::class, 'indexTeacher'])->name('notice_teacher');
    Route::get('/notice_staff', [NoticeController::class, 'indexStaff'])->name('notice_staff');
    Route::post('/store_notice', [NoticeController::class, 'store'])->name('notice_store');
    Route::post('/update_notice', [NoticeController::class, 'update'])->name('notice_update');
    Route::post('/remove_notice', [NoticeController::class, 'destroy'])->name('notice_remove');

    Route::get('/birthday', [BirthdayController::class, 'index'])->name('birthday');
    Route::post('/store_birthday', [BirthdayController::class, 'store'])->name('birthday_store');
    Route::post('/update_birthday', [BirthdayController::class, 'update'])->name('birthday_update');
    Route::post('/remove_birthday', [BirthdayController::class, 'destroy'])->name('birthday_remove');


   Route::post('/remove_birthday', [BirthdayController::class, 'destroy'])->name('birthday_remove');


Route::get('/video_rec_issues', [VideoRecIssuesController::class, 'index'])->name('video_rec.issues');
Route::post('/video_rec_store', [VideoRecIssuesController::class, 'store'])->name('video_rec.issues_store');
Route::post('/update_video_rec_issues', [VideoRecIssuesController::class, 'update'])->name('video_rec.issues_update');
Route::post('/video_rec_remove', [VideoRecIssuesController::class, 'destroy'])->name('video_rec.issues_remove');


Route::get('/teacher-intro', [TeacherIntroController::class, 'index'])->name('teacher_intro');
Route::post('/teacher_intro_store', [TeacherIntroController::class, 'store'])->name('teacher_intro.store');
Route::post('/update_teacher_intro', [TeacherIntroController::class, 'update'])->name('teacher_intro.update');
Route::post('/teacher_intro_remove', [TeacherIntroController::class, 'destroy'])->name('teacher_intro.remove');

Route::post('/item_categories_index', [ItemShopCategoryController::class, 'index'])->name('iteam_categories.index');
Route::post('/item_categories_store', [ItemShopCategoryController::class, 'store'])->name('iteam_categories.store');
Route::post('/item_categories_update', [ItemShopCategoryController::class, 'update'])->name('iteam_categories.update');
Route::post('/item_categories_delete', [ItemShopCategoryController::class, 'destroy'])->name('iteam_categories.destroy');

Route::get('/item_index', [ItemShopController::class, 'index'])->name('iteam.index');
Route::post('/item_store', [ItemShopController::class, 'store'])->name('iteam.store');
Route::post('/item_update', [ItemShopController::class, 'update'])->name('iteam.update');
Route::post('/item_delete', [ItemShopController::class, 'destroy'])->name('iteam.destroy');


 
    
    
    
}); 

//Route::resource('/subjects', [SubjectController::class, 'index'])->middleware('check.apikey');