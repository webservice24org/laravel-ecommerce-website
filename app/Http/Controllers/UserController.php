<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use Exception;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
                'message'=>$e->getMessage
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
}
