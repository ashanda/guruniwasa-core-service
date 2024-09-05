<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAttendence extends Model
{
    use HasFactory;
    protected $fillable = [
        'lesson_id',
        'student_id',
        'subject_id',
        'teacher_id',
        'attendence',
        'lesson_date',
        'class_type',
    ];
}
