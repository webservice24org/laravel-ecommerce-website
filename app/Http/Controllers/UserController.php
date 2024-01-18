<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\OTPMail;
use Exception;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    function UserRegistration(Request $request){
        try{
            $request->validate([
                "firstName"=>"required|string",
                "lastName"=> "required|string",
                "email"=> "required|string",
                "mobile"=>"required",
                "password"=> "required|string|min:8"
            ]);
            User::create([
                'firstName' =>$request->input('firstName'),
                'lastName' =>$request->input('lastName'),
                'email' =>$request->input('email'),
                'mobile' =>$request->input('mobile'),
                'password' =>Hash::make($request->input('password'))
            ]);
    
            return response()->json([
                'status'=>'success',
                'message'=>'User registered successfully'
            ],status:200);
        }catch (Exception $e){
            return response()->json([
                'status'=>'Faild',
                'message'=>$e->getMessage()
            ],200);
        }
    }

    function UserLogin(Request $request){
        try {
            $count = User::where('email', $request->input('email'))
                ->where('password', Hash::make($request->input('password')))
                ->count();
            
            Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')]);
            $token = JWTToken::CreateToken($request->input('email'));
            
            return response()->json([
                'status' => 'success',
                'message' => 'User Login Success',
                'token' => $token
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred during login',
                'error' => $e->getMessage()
            ], 200);
        }
            
    }


    function sendOtoMail(Request $request){
        try {  
            $request->validate([
                'email'=> 'required'
            ]);
            $email = $request->input('email');
            $otp = rand(100000,999999);
            $count = User::where('email','=', $email)->count();
            if ($count==1) {
               Mail::to($email)->send(new OTPMail($otp));
               User::where('email','=', $email)->update(['otp'=> $otp]);
               return response()->json([
                    'status'=> 'success', 
                    'message'=> '6 Digit Otp Code sent to your mail'
               ],200);
            }else {
                return response()->json([
                    'status'=>'Fail', 
                    'message'=>'Invalid Email Address / OTP Code'
                ],200);
            }
         } 
         catch (Exception $e) {
            return response()->json([
                'status'=> 'Fail',
                'message'=> $e->getMessage()
            ],200);
         }
    }

    function verifyOtp(Request $request){
        try {
            $request->validate([
                'email'=> 'required',
                'otp' => 'required|min:6'
            ]);
            $email = $request->input('email');
            $otp = $request->input('otp');
            $user = User::where('email','=', $email)->where('otp','=', $otp)->first();

            if (!$user) {
                return response()->json([
                    'status'=> 'Fail',
                    'message'=> 'Invalid Otp'
                ]);
            }
            User::where('email','=', $email)->update(['otp'=> '0']);
            $token = JWTToken::CreateTokenPass($request->input('email'));
            return response()->json([
                'status'=> 'success',
                'message'=> 'Otp Verification Success',
                'token'=> $token
            ],200);
        }
        catch (Exception $e) {
            return response()->json([
                'status'=> 'Fail',
                'message'=> $e->getMessage()
            ],200);
        }
    }


    function resetPassword(Request $request){ 
        try {
            $email = $request->header('email');
            $password = Hash::make($request->input('password'));
            
            User::where('email','=', $email)->update(['password'=> $password]);
            return response()->json([
                'status'=> 'success',
                'message'=> 'Password Reset Success'
            ]);
        }
        catch (Exception $e) {
            return response()->json([
                'status'=> 'Fail',
                'message'=> $e->getMessage()
            ]);
        }
     }

}
