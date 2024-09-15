<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'scheduled_lesson_id',
        'teacher_id',
        'grade_id',
        'subject_id',
        'lesson_title',
        'video_url1',
        'video_url2',
        'video_thumb',
        'status',
    ];

    // Define the relationship if necessary
    public function scheduledLesson()
    {
        return $this->belongsTo(ScheduledLesson::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
}
