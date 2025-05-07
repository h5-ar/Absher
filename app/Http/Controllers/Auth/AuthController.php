<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class AuthController extends Controller
{   
    public function login(Request $request)
    {

        $user = User::where('email', $request->email)->first();
    
        $code='1234';

        $user->update(['otp'=>$code,'otp_expired_at'=>now()->addMinutes(10)]);

        //send email with otp;

        return response()->json(["message"=> 'Code sent successfully']);
    }

    public function checkCode(Request $request)
    {
        $user  = User::where('email', $request->email)->first();


        if(isset($user) && now()->lte($user->otp_expired_at) && $user->otp==$request->otp){
                $user->update([
                    'user_verified_at' => now() 
                ]);
                return response()->json([
                    "message" => "Code Checked Successfully.",
                    'token'      => $user->createToken()->plainTextToken,
                ]);
        }
        return response()->json(["message"=> 'Invalid verification code'], status: 401);
    }



    public function register(Request $request)
    {
        $request->validate([
            'email'=>'required|email|unique:users,email',
            'name'=>'required|string|min:5|max:100',
            'password' =>['required','string','min:8','max:20']
        ]);     
        
       $user= User::create([
            'password' => $request->get('password'),
            'email' => $request->get('email'),
            'name' => $request->get('name'),     
            'otp' =>$otp='1234',
            'otp_expired_at' =>now()->addMinutes(10)
            ]);
            
        return response()->json([
            'message'  =>  "User Registed Successfully.",
        ]);
    }
}
