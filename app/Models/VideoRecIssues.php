<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoRecIssues extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','lesson_id','issues'];

    
    public function lessons()
    {
        return $this->belongsTo(VideoRecord::class, 'id', 'id');
    }

    
}
