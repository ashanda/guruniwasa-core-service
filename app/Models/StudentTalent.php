<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentTalent extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'talent_link',
    ];
}
