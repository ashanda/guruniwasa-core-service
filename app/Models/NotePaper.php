<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotePaper extends Model
{
    use HasFactory;
     protected $fillable = [
        'subject_id',
        'teacher_id',
        'grade_id',
        'title',
        'directory'
    ];


    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function studentUploads()
    {
        return $this->hasMany(StudentNote::class, 'note_id');
    }

    
}
