<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    protected $table = 'offers';
    protected $fillable = [
        'product_photo',
        'product_name',
        'discount',
        'discount_start_date',
        'final_price_package',
        'discount_end_date',];
}
