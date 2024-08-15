<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $fillable = [
        'gid',
        'sname',
        'fee',
        'fees_valid_period',
        'whats_app',
        'class_type',
        'day_normal',
        'start_normal',
        'end_normal',
        'day_extra1',
        'start_extra1',
        'end_extra1',
        'day_extra1_status',
        'day_extra2',
        'start_extra2',
        'end_extra2',
        'day_extra2_status',
        'status',
    ];

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'gid', 'id');
    }

    public function videoRecords()
    {
        return $this->hasMany(VideoRecord::class,'subject_id','id');
    }

    public function classtutes()
    {
        return $this->hasMany(Classtute::class, 'subject_id');
    }

    
}
