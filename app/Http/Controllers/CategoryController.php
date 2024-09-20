<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use Validator;
class CategoryController extends Controller
{
 public function create (Request $request)
 {  
  $rules=array(
    "name"=>"required",
  );
  $validator=Validator::make($request->all() , $rules);
  if($validator->fails()){
    return $validator->errors();
  }
  else
  {
   $category = new Category;
   $category->name=$request->name;
   $result=$category->save();
   if($result){
    return ["Result"=>"data has been saved"];
 }
 return ["Result"=>"operation failed"];
 }

}
 public function index()
 {
   return Category::all();
 }
public function show($id)
 { 
    return Category::find($id);
    
 }

 public function update ($id,Request $request)
 { 
  $rules=array(
    "name"=>"required|min:2|max:9"
  );
  $validator=Validator::make($request->all() , $rules);
  if($validator->fails()){
    return $validator->errors();
  }
  else
  {
   $category= Category::find($request->id);
   $category->name=$request->name;
   
}
   $result=$category->save();
   if($result){
    return ["Result"=>"data has been updated"];
 }
 return ["Result"=>"operation failed"];
 }

public function delete($id)
{  
   $category= Category::find($id);
   $result=$category->delete();
   if($result)
   {
    return ["Result"=>"data has been deleted"];
 }
 return ["Result"=>"operation failed"];

}
public function search(Request $request)
{

return Category::where("name","like","%".$request->name."%")->get();
}

}