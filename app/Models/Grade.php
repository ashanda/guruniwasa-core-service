<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;
    protected $fillable = [
        'gname',
    ];

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'gid', 'id');
    }
}
