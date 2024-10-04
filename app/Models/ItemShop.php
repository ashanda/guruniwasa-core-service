<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemShop extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'code',
        'category_id',
        'commission_account',
        'commission_account_id',
        'rate',
        'price',
        'weight',
        'details',
        'image_path',
    ];
    protected $dates = ['deleted_at'];


    public function category()
    {
        return $this->belongsTo(ItemShopCategory::class , 'category_id', 'id');
    }
}
