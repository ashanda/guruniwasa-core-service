<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassPaper extends Model
{
    use HasFactory;
    protected $fillable = [
        'teacher_id',
        'grade_id',
        'subject_id',
        'lesson_title',
        'paper_url',
        'status',
    ];



    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function ClassPaperSubject()
    {
         return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
}
