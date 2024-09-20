<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Package;
use Validator;
use DB;
use Carbon\Carbon;
class PackageController extends Controller
{
 public function addpackage(Request $request)
{
   if( auth()->user()->id ==1 )
           {
    foreach($request->packages as $offer)
    {
     $newOffer = Package::query()->create([
     'product_id' =>$offer['product_id'],
     'product_name' => Product::where("id","=",$offer['product_id'])->value('product_name'),
     'first_unit' => Product::where("id","=",$offer['product_id'])->value('first_unit'),
     'second_unit' => Product::where("id","=",$offer['product_id'])->value('second_unit'),
     'third_unit' => Product::where("id","=",$offer['product_id'])->value('third_unit'),
     'price_first_unit' => Product::where("id","=",$offer['product_id'])->value('price_first_unit'),
     'price_package' => Product::where("id","=",$offer['product_id'])->value('price_package'),
     'category_name' => Product::where("id","=",$offer['product_id'])->value('category_name'),
     'photo' => Product::where("id","=",$offer['product_id'])->value('photo'),
     'package_packing' => Product::where("id","=",$offer['product_id'])->value('package_packing'),
     'discount_start_date'=>Carbon::now()->tz('Europe/London')->addHours(2)->format('Y-m-d H:i A'),
    'discount_end_date'=> $request->discount_end_date,
   'final_price_package'=> $request->final_price_package,
     ]);
    }
    if($request->hasFile('package_photo'))
   {
    $photoName=rand().time().'.'.$request->package_photo->getClientOriginalExtension();
    $path=$request->file('package_photo')->move('upload/', $photoName );
    $newOffer->package_photo=$photoName ;
   }
  $newOffer->update([
    'offer_name'=>$request->offer_name,
    'package_photo'=>$request->package_photo,
   'discount'=>$request->discount,
   'discount_end_date'=> $request->discount_end_date,
   'final_price_package'=> $request->final_price_package
   ]);
  $result=$newOffer->save();
  
  
       if($result)
       {
        return ["Result"=>"data has been created"];
        }
        }
            else
            {
                return ["error"=>"you dont have permission to do this "];
            }  

 }


 public function index()
 {
    $packages=Package::all();
    foreach ($packages as $package ) {
    $date1=Carbon::createFromFormat('Y-m-d',$package->discount_end_date);
    $date2=Carbon::now()->tz('Europe/London')->addHours(2)->format('Y-m-d');
    if($date1->lt($date2))
    {
    DB::table('packages')->where('id','=',$package->id)->update(['expire'=> 1]);
    }
    }
    return Package::select('id','offer_name','package_photo','discount')->where('expire','=',0)->whereNotNull('offer_name')->get(); 
 }


public function DetailPackage($id)
 {
  $discount_start_date=DB::table('packages')->where('id','=',$id)->value('discount_start_date');
  $final_price_package=Package::where('discount_start_date','=',$discount_start_date)->value('final_price_package');
  $discount_end_date=Package::where('discount_start_date','=',$discount_start_date)->value('discount_end_date');
   $packages=DB::table('packages')->where('discount_start_date','=',$discount_start_date)->select('product_id','product_name','first_unit','second_unit','third_unit','photo','package_packing','price_first_unit','price_package','category_name',)->get();
  return [
  'packages'=>$packages,
  'discount_end_date'=>$discount_end_date,
  'final_price_package'=>$final_price_package,
  ];

}

public function delete($id)
    {
      if( auth()->user()->id ==1 )
           {
       
       $package= Package::find($id);
       $result=$package->delete();
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


public function update(Request $request , $id)
 { 
  if(auth()->user()->id==1)
       {
   $package= Package::find($id);
   foreach($request->packages as $offer)
    {
     $newOffer = Package::query()->create([
     'product_id' =>$offer['product_id'],
     'discount_start_date'=>Carbon::now()->tz('Europe/London')->addHours(2)->format('Y-m-d H:i A'),
    'discount_end_date'=> $request->discount_end_date,
   'final_price_package'=> $request->final_price_package,
     ]);
    }
    if($request->hasFile('package_photo'))
   {
    $photoName=rand().time().'.'.$request->package_photo->getClientOriginalExtension();
    $path=$request->file('package_photo')->move('upload/', $photoName );
    $newOffer->package_photo=$photoName ;
   }
  $newOffer->update([
    'offer_name'=>$request->offer_name,
    'package_photo'=>$request->package_photo,
   'discount'=>$request->discount,
   'discount_end_date'=> $request->discount_end_date,
   'final_price_package'=> $request->final_price_package
   ]);
  $result=$newOffer->save();
       if($result)
       {
        return ["Result"=>"data has been updated"];
        }
        }
            else
            {
                return ["error"=>"you dont have permission to do this "];
            }  

 }

}