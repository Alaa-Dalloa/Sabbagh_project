<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Validator;
use DB;

class ProductController extends Controller
{
   public function create (Request $request)
 { 
  $rules=array(
    "product_name"=>"required" , 
    "first_unit"=>"required",
   "price_first_unit"=>"required",
   "second_unit"=>"required",
  );
  $validator=Validator::make($request->all() , $rules);
  if($validator->fails()){
    return $validator->errors();
  }
  else
  {
   $product = new Product;
   $product->product_name=$request->product_name;
   $product->first_unit=$request->first_unit;
   $product->price_first_unit=$request->price_first_unit;
   $product->second_unit=$request->second_unit;
   $product->third_unit=$request->third_unit;
   if($request->hasFile('photo'))
   {
    $photoName=rand().time().'.'.$request->photo->getClientOriginalExtension();
    $path=$request->file('photo')->move('upload/', $photoName );
    $product->photo=$photoName ;
   }
   $product->package_packing=$request->package_packing;
   $product->price_package=$request->price_first_unit-($request->price_first_unit*0.1);
   $product->category_name=$request->category_name;
  $result=$product->save();
  if($result)
  {
    return ["Result"=>"data has been saved"];
 }
 return ["Result"=>"operation failed"];
}

}

 public function index()
 {
   return Product::all();

 }

public function delete($id)
{
   
   $product= Product::find($id);
   $result=$product->delete();
   if($result)
   {
    return ["Result"=>"data has been deleted"];
   }
   return ["Result"=>"operation failed"];
}

 public function show($id)
 {  
    
    return Product::find($id);
    
 }

 public function update (Request $request , $id)
 { 
  $rules=array(
   "product_name"=>"required" , 
    "first_unit"=>"required",
   "price_first_unit"=>"required",
   "second_unit"=>"required",
   "third_unit"=>"required",
   "photo"=>"required",
   "package_packing"=>"required",
   "category_name"=>"required",
  );

  $validator=Validator::make($request->all() , $rules);
  if($validator->fails())
  {
    return $validator->errors();
  }
  else
{
  $product= Product::find($id);
   $product->product_name=$request->product_name;
   $product->first_unit=$request->first_unit;
   $product->price_first_unit=$request->price_first_unit;
   $product->second_unit=$request->second_unit;
   $product->third_unit=$request->third_unit;
   if($request->hasFile('photo'))
   {
    $photoName=rand().time().'.'.$request->photo->getClientOriginalExtension();
    $path=$request->file('photo')->move('upload/', $photoName );
    $product->photo=$photoName ;
   }
   $product->category_name=$request->category_name;
   $product->package_packing=$request->package_packing;
   $result=$product->save();
   if($result)
   {
    return ["Result"=>"data has been update"];
   }
 return ["Result"=>"operation failed"];
}
}

 public function showProductByCategory($name)
 {  
    
   return Product::where('category_name','=',$name)->get();
   
 }



public function search(Request $request)

{

return Product::where("product_name","like","%".$request->product_name."%")->get();
}

}
