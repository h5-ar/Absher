<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /*public function login(Request $request)
    {
        // dd($request->email);

        $user = User::where('email', $request->email)->first();

      if ($user && HASH ::check($request->password, $user->password)) {
        // البيانات صحيحة - يمكن تسجيل الدخول
        return response()->json(['message' => 'تم تسجيل الدخول بنجاح']);
    } else {
        // البيانات غير صحيحة
        return response()->json(['message' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة'], 401);
    }


        $token = $user->createToken('apiToken');

      return  response()->json(['token' => $token]);

        $code='1234';

       // $user->update(['otp'=>$code,'otp_expired_at'=>now()->addMinutes(10)]);

        //send email with otp;

        return response()->json(["message"=> ' blablabla']);
    }*/
     public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // إنشاء التوكن
            $token = $user->createToken('apiToken')->plainTextToken;
            //$userid=$users->id,


            return response()->json([
                'message' => 'تم تسجيل الدخول بنجاح',
                'access_token' => $token,
                //'user_id'=>$userId,
                 'user_id' => $user->id,
                'token_type' => 'Bearer',
            ]);
        } else {
            return response()->json([
                'message' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة',
            ], 401);
        }
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
            'first_name'=>'required|string|min:3|max:100',
            'last_name'=>'required|string|min:3|max:100',
            'password' =>['required','string','min:8','max:20',
            'phone'=>'required','string','min:10','max:10']
        ]);

       $user= User::create([
            'password' => HASH::MAKE($request->get('password')),
            'email' => $request->get('email'),
            'first_name' => $request->get('first_name'),
            'username' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'phone'=>$request->get('phone'),
            'otp' =>$otp='1234',
            'otp_expired_at' =>now()->addMinutes(10)
            ]);

        return response()->json([
            'message'  =>  "User Registed Successfully.",
        ]);
    }
}
