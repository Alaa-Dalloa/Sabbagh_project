<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use DB;
use App\Models\Bearen;
use Carbon\Carbon;
use Http;
class BearenController extends Controller
{
   public function bearen ()
 { 
    $bearen = new Bearen;
    $bearen->daily_order_date=Carbon::now()->tz('Europe/London')->addHours(2)->format('Y-m-d');
    $bearen->daily_order_sell_price=DB::table('orders')->where('daily_order_date','=',$bearen->daily_order_date)->select('product_price')->sum('product_price');   
    $bearen->save();  

    return DB::table('bearens')->select('daily_order_date','daily_order_sell_price')->distinct()->get('daily_order_date');
}
}
