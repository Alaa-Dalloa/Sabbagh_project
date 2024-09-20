<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = [
        'product_photo',
        'product_name',
        'quantity',
        'product_price',
        'governorat',
        'countr',
        'other_detail',
        'daily_order_date',
        'phone',
        'order_date',
        'user_name',
        'order_price_total'
    ];
}

