<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IncomeTaxPayment extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'date', 'payment_details', 'document',
    ];
}
