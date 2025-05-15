<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\SuperAdmin;

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
        $company = Company::where('username', $request->username)->first();

        if (isset($company) && Hash::check($request->password, $company->password)) {
            auth()->login($company);
            return redirect()->route('dashboard');
        }

        $superAdmin = SuperAdmin::where('username', $request->username)->first();

        if (isset($superAdmin) && Hash::check($request->password, $superAdmin->password)) {
            auth()->guard('super_admin')->login($superAdmin);
            return redirect()->route('super_admin.dashboard');
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
