<?php

namespace App\Http\Controllers;
use App\Http\LaratrustUserTrait;
use Illuminate\Http\Request;
use App\Models\Role;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use Http;
use Tymon\JWTAuth\Exceptions\JWTException;
class AdminController extends Controller
{

    public function addManger(Request $request)
        {
             if(auth()->user()->id==1)
       {
                $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',

            ]);

            if($validator->fails()){
                    return response()->json($validator->errors()->toJson(), 400);
            }

            $user = User::create([
                'first_name' => $request->get('first_name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
                'last_name' => $request->get('last_name'),
                'user_type'=>'manger',
            ]);
           // $user->attachRole('manger');
          $user->save();
        

            $token = JWTAuth::fromUser($user);

             return [
            'user'=>$user,
            'password_user'=>$request->get('password'),
            'token'=>$token

            ];
        }
        
        else
        {
            return ["error"=>"you dont have permission to do this"];
        }
        
        }

        public function addDelivary(Request $request)
        {
             if(auth()->user()->id==1)
       {
                $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',

            ]);

            if($validator->fails()){
                    return response()->json($validator->errors()->toJson(), 400);
            }

            $user = User::create([
                'first_name' => $request->get('first_name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
                'last_name' => $request->get('last_name'),
                'user_type'=>'supplier',
            ]);
          $user->save();
        

            $token = JWTAuth::fromUser($user);

             return [
            'user'=>$user,
            'password_user'=>$request->get('password'),
            'token'=>$token

            ];
        }
        
        else
        {
            return ["error"=>"you dont have permission to do this"];
        }
        
        }

    public function indexManger()
    
    {
        return User::where("user_type","like","manger")->select('id','first_name','last_name','email','password','user_type')->get();

    }


    public function indexDelivary()
    
    {
       return User::where("user_type","like","supplier")->select('id','first_name','last_name','email','password','user_type')->get();

    }


    public function searchMoD($first_name)
    {

    return User::where("first_name","like","%".$first_name."%")->get();
    }


    public function deleteMoD($id)
        {  
             if(auth()->user()->id==1)
       {
            $user= User::find($id);
            $result=$user->delete();
            if($result)
             {
                return ["Result"=>"data has been deleted"];
              }
     
     }
        else
        {
            return ["error"=>"you dont have permission to do this"];
        }
    }


    public function update ($id,Request $request )
 { 
   if(auth()->user()->user_type=='super_admin')
    {
   $user = User::find($request->id);
   if($request->user_type =='supplier')
  {
   $user->user_type='supplier';
  }
   if($request->user_type =='manger')
  {
   $user->user_type='manger';
  }
   $result=$user->save();
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