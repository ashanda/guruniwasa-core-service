<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentNote extends Model
{
    use HasFactory;
    protected $fillable = [
        'note_id',
        'student_id',
        'grade_id',
        'subject_id',
        'teacher_id',
        'directory',
        'status',
    ];



    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }


    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
}
