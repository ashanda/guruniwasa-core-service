<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaxPayment extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'name', 'job_role', 'tax_amount', 'payment_date', 'document',
    ];
    
}
