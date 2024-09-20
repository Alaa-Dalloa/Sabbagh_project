<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Validator;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;
use Http;
class OrderController extends Controller
{
 public function create (Request $request)
 { 
    $fcm_token=User::where('user_type','=','supplier')->value('fcm_token');
    $server_key=env('FCM_SERVER_KEY');
    $URL='https://fcm.googleapis.com/fcm/send';
     foreach ($request->orders as $order)
    {
     $newOrder = Order::query()->create([
     'product_name' =>$order['product_name'],
     'quantity' => $order['quantity'],
     'product_photo' =>$order['product_photo'],
     'product_price' => $order['product_price'],
    'order_price_total'=> $request->order_price_total,
    'order_date'=>Carbon::now()->tz('Europe/London')->addHours(2)->format('Y-m-d H:i A'),
    'daily_order_date'=>Carbon::now()->tz('Europe/London')->addHours(2)->format('Y-m-d'),
     ]);
     }
    $newOrder->update([
   'user_name'=>auth()->user()->first_name,
   'phone'=>auth()->user()->phone,
   'governorat'=>auth()->user()->governorate,
   'countr'=>auth()->user()->country,
   'other_detail'=>auth()->user()->other_details,
   'order_price_total'=> $request->order_price_total,
   'order_date'=>Carbon::now()->tz('Europe/London')->addHours(2)->format('Y-m-d H:i A'),
   ]);
    $result=$newOrder->save();

    $post_data=
          '{
          "to" : "' . $fcm_token . '",
          "notification" : {
          "title" : "There are new request order",
          "body" : "' . $result . '"
          },
        }';
     
    $crl= curl_init();

    $headr = array();
    $headr[] = 'Content-Type: application/json';
    $headr[] = 'Authorization: key=' . $server_key;
    curl_setopt($crl, CURLOPT_SSL_VERIFYPEER , false);

    curl_setopt($crl, CURLOPT_URL ,  $URL);
    curl_setopt($crl, CURLOPT_HTTPHEADER, $headr);


    curl_setopt($crl, CURLOPT_POST, true);
    curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);

    $ex=curl_exec($crl);

      return response()->json($ex);
       
 }


 public function index()
 {
   return Order::select('id','user_name','order_date')->where('status_order','=',0)->whereNotNull('user_name')->get();
 }


 public function myOrders()
 {
   $user_name=auth()->user()->first_name;
   return Order::select('id','order_date')->where('user_name','=',$user_name)
   ->whereNotNull('user_name')->get();
 }


public function delete($id)
{ 
   $order= Order::find($id);
   $result=$order->delete();
   if($result){
    return ["Result"=>"data has been deleted"];
  }
 return ["Result"=>"operation failed"];
}

 

 public function DetailOrder($id)
 {
  
  $order_date=DB::table('orders')->where('id','=',$id)->value('order_date');
  $user_name=DB::table('orders')->where('order_date','=',$order_date)->whereNotNull('user_name')->value('user_name');
  $governorat=DB::table('orders')->where('order_date','=',$order_date)->whereNotNull('governorat')->value('governorat');
  $countr=DB::table('orders')->where('order_date','=',$order_date)->whereNotNull('countr')->value('countr');
  $other_detail=DB::table('orders')->where('order_date','=',$order_date)->whereNotNull('other_detail')->value('other_detail');
  $phone=DB::table('orders')->where('order_date','=',$order_date)->whereNotNull('phone')->value('phone');
  $order_price_total=Order::where('order_date','=',$order_date)->value('order_price_total');
  $orders=DB::table('orders')->where('order_date','=',$order_date)->select('product_name','product_photo','product_price','quantity')->get();
  return [
  'orders'=>$orders,
  'governorat'=>$governorat,
  'countr'=>$countr,
  'other_detail'=>$other_detail,
  'phone'=>$phone,
  'user_name'=>$user_name,
  'order_price_total'=>$order_price_total,
  ];

 }

   public function mySales()
    {
      return Order::select('id','product_name','product_photo')->get();
    }

     public function update ($id,Request $request )
 { 
   if(auth()->user()->user_type=='supplier')
    {
   $order = Order::find($request->id);
   if($request->status_order ==1 )
  {
   $order->status_order=1;
  }
   $result=$order->save();
   if($result)
   {
    return ["Result"=>"data has been update"];
   }
    }
        else
        {
            return ["error"=>"you dont have permission to do this"];
        }
}
 
   
}




