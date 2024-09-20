<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    protected $table = 'packages';
    protected $fillable = [
        'offer_name',
        'package_photo',
        'product_id',
        'first_unit',
        'discount',
        'product_name',
        'price_first_unit',
        'second_unit',
        'third_unit',
        'photo',
        'package_packing',
        'price_package',
        'discount_start_date',
        'final_price_package',
        'category_name',
        'discount_end_date'
    ];
}
