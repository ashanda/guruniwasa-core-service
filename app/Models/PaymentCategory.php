<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentCategory extends Model
{
    use HasFactory, SoftDeletes; 

    protected $fillable = ['name', 'parent_id'];

    public function parent()
    {
        return $this->belongsTo(ReceiptCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ReceiptCategory::class, 'parent_id');
    }
}
