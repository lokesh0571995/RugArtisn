<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Session;
use Log;
use DB;


class RegisterController extends Controller
{
    public function register(Request $request)
    {
       
        try {
           
                $validator = Validator::make($request->all(), [
                    'name'       => 'required|max:100',
                    'email'      => 'required|email|unique:users,email|max:250',
                    'mobile'     => 'required|numeric|unique:users,mobile|digits_between:8,15',
                    'password'   => 'required|min:8',
                    'confirm_password' => 'required|same:password',
                ]);
                
                if($validator->fails()){
                    return response()->json(['Errors.', $validator->errors()],422);       
                }
        
                //store register data
                Log::info('User store data');
                
                $user              = new User();
                $user->name        = $request->name; 
                $user->email       = $request->email;
                $user->mobile      = $request->mobile;
                $user->password    = bcrypt($request['password']);
                $user->role        = 2; 
                $user->save();
                
                if($user->save()){

                    Log::info('User store data');
                    return response()->json(['status'=>true,'message'=>'User register successfully!','data'=>$user],200);

                }else{
                    Log::info('User not register successfully!');
                    return response()->json(['success' => false,'message' => 'User not register successfully!'], 400);
                }
               
               
            } catch (\Exception $e) {
               
                return response()->json(['status'=>false,'message'=>'something went wrong'],500);
            }
    }

    public function login(Request $request)
    {
        try {
                $validator = Validator::make($request->all(), [
                
                    'email'      => 'required|email|max:250',
                    'password'   => 'required|min:8',
                
                ]);
        
                if($validator->fails()){
                    return response()->json(['Errors.', $validator->errors()],422);           
                }

                // Throttle the login attempts…
                Log::info('add login rate limiter!');


                $this->middleware('throttle:60,1')->only('login');
 
                if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 

                    Log::info('check auth user!');
                    $user  = Auth::user(); 
                    $token =   $user->createToken("RugArtisan")->accessToken; 
                    if($user->role ==1){

                        Log::info('Admin login successfully!');
                        return response()->json(['status'=>true,'message'=>'Admin login successfully!','token'=>$token,'data'=>$user],200);
                    }else{
                        Log::info('User login successfully!');

                        return response()->json(['status'=>true,'message'=>'User login successfully!','token'=>$token,'data'=>$user],200);
                    }
                    
                } 
                else{ 

                    Log::warning('Email or Password is wrong!');

                    return response()->json(['status'=>false,'message'=>'Email or Password is wrong!'],401);
                } 

              
            }catch (\Exception $e) {
                Log::error('something went wrong!');
               
                return response()->json(['status'=>false,'message'=>'something went wrong!'],500);
            }    
    }

    public function logout(){

        Session::flush();
        
        return response()->json(['status'=>true,'message'=>'User logout successfully!'],200);
    }
}
