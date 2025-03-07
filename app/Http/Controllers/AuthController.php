<?php
namespace App\Http\Controllers;

use App\Models\Company;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        return view('Auth.Login');
    }

    public function login(Request $request)
    {
        $user = Company::where('username', $request->username)->first();
        if (isset($user) && $request->password == $user->password) {
            //auth()->login($user);

            return redirect()->route('dashboard');
        }
        return redirect()->back()->withErrors(translate('Invalid username or password'));
    }

    public function logout()
    {
        $theme = Session::get('theme') ?? 'semi-dark-layout';
        session()->invalidate();
        session()->put('theme', $theme);
        return to_route('login');
    }
}
