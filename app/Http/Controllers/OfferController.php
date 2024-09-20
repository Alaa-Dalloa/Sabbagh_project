<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Offer;
use Validator;
use Carbon\Carbon;
use DB;
class OfferController extends Controller
{
  public function create (Request $request)
 { 
   if(auth()->user()->id==1)
       {
  $rules=array(
    "product_name"=>"required",
    "discount"=>"required",
    "discount_end_date"=>"required"
  );
  $validator=Validator::make($request->all() , $rules);
  if($validator->fails())
  {
    return $validator->errors();
  }
  else
  {
   $offer = new Offer;
   $offer->discount_start_date=Carbon::now()->tz('Europe/London')->addHours(2)->format('Y-m-d');
   $offer->discount_end_date=$request->discount_end_date;
   $offer->discount=$request->discount;
   $offer->product_name=$request->product_name;
   $offer->product_photo=Product::where("product_name","like","%".$request->product_name."%")->value('photo');
   $offer->final_price=$request->discount*1/100*Product::where("product_name","like","%".$request->product_name."%")->value('price_first_unit');
   $result=$offer->save();
   if($result){
    return ["Result"=>"Offer added sucsess"];

 }
 }
 }
 else
    {
    return ["error"=>"you dont have permission to do this"];
    }    

}

 
 public function index()
 {
    $offers=Offer::all();
    foreach ($offers as $offer ) {
    $date1=Carbon::createFromFormat('Y-m-d',$offer->discount_end_date);
    $date2=Carbon::now()->tz('Europe/London')->addHours(2)->format('Y-m-d');
    if($date1->lt($date2))
    {
    DB::table('offers')->where('id','=',$offer->id)->update(['expire'=>1]);
    }
    }
  return DB::table('offers')->where('expire','=',0)->get();
 }


 public function show($id)
 {  
    
    return Offer::find($id);
    
 }


 public function update(Request $request , $id)
 { 
  if(auth()->user()->id==1)
       {
  $rules=array(
    "discount_end_date"=>"required",
    "discount"=>"required",
    "product_name"=>"required"
  );

  $validator=Validator::make($request->all() , $rules);
  if($validator->fails()){
    return $validator->errors();
  }
  else
{
  $offer= Offer::find($id);
   $offer->discount_start_date=Carbon::now();
   $offer->discount_end_date=$request->discount_end_date;
   $offer->discount=$request->discount;
   $offer->product_name=$request->product_name;
   $offer->product_photo=Product::where("product_name","like","%".$request->product_name."%")->value('photo');
   $offer->final_price=$request->discount*1/100*Product::where("product_name","like","%".$request->product_name."%")->value('price_first_unit');
   $result=$offer->save();
   if($result)
   {
    return ["Result"=>"data has been update"];
   }
 }
}
        else
        {
            return ["error"=>"you dont have permission to do this"];
        }    

 }

    public function delete($id)
    {
      if( auth()->user()->id ==1 )
           {
       
       $offer= Offer::find($id);
       $result=$offer->delete();
       if($result)
       {
        return ["Result"=>"data has been deleted"];
        }
           }
            else
            {
                return ["error"=>"you dont have permission to do this "];
            }    
    }

  
}

