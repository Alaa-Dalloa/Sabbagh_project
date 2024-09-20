<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Validator;
use DB;
use Illuminate\Http\Request;

class WholeSaleController extends Controller
{


    public function create_form(Request $request) {
        $fcm_token=User::where('user_type','=','super_admin')->value('fcm_token');
        $server_key=env('FCM_SERVER_KEY');
        $URL='https://fcm.googleapis.com/fcm/send';
        $validator = Validator::make(request()->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'governorate' => 'required',
            'country' => 'required',
            'other_details' => 'required',
            'library_name' => 'required',
            'library_phone' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:5',
        ]);
 
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
 
        $user = new User;
        $user->first_name = request()->first_name;
        $user->last_name = request()->last_name;
        $user->email = request()->email;
        $user->password = bcrypt(request()->password);
        $user->phone = request()->phone;
        $user->governorate = request()->governorate;
        $user->country = request()->country;
        $user->other_details = request()->other_details;
        $user->library_name = request()->library_name;
        $user->library_phone = request()->library_phone;
        $user->user_type = 'wholeSale_customer';
        $user=$user->save();

        $post_data=
          '{
          "to" : "' . $fcm_token . '",
          "notification" : {
          "title" : "There are new request form",
          "body" : "' . $user . '"
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
   /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function index()
    {  
        return DB::table('users')->whereNotNull('library_name')->where('user_type','=','wholeSale_customer')->where('status','=',0)->get();
    }

    public function update ($id,Request $request )
 { 
   if(auth()->user()->user_type=='super_admin')
    {
   $user = User::find($request->id);
   if($request->status ==1 )
  {
   $user->status=1;
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
