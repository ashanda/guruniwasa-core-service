<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduledLesson extends Model
{
    use HasFactory;
   protected $fillable = [
        'teacher_id',
        'grade_id',
        'subject_id',
        'lesson_title',
        'lesson_date',
        'day_of_week',
        'start_time',
        'end_time',
        'zoom_link',
        'password',
        'class_status',
        'special_note',
        'is_recurring',
        'recurrence_type',
        'status',
    ];

    

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
