<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudenttermTest extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'subject_id',
        'teacher_id',
        'grade_id',
        'first_term' ,
        'first_marks' ,
        'second_term',
        'second_marks',
        'third_term',
        'third_marks',
    ];
}
