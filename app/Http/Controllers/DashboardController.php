<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateCompanyRequest;


class DashboardController extends Controller
{
    public function index()
    {
        return view('Dashboard.Admin.dashboard');
    }

    public function switchLang()
    {
        $lang = match (app()->getLocale()) {
            'ar'    => 'en',
            'en'    => 'ar',
        };

        Session::put('lang', $lang);
        return redirect()->route('dashboard');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('Dashboard.Admin.Profile.show', compact('user'));
    }
    public function editprofile($id)
    {
        $company = Company::findOrFail($id);
        return view('Dashboard.Admin.Profile.edit', compact('company'));
    }

    public function updateprofile(UpdateCompanyRequest $request, $id)
    {
        $company = Company::findOrFail($id);

        $company->update([
            'name' => $request['name'],
            'phone' => $request['phone'],
            'email' => $request['email'],
            'username' => $request['username'],
            'password' => Hash::make($request->input('password')),
            'Description' => $request['description'],
            'manager_id' => $request['manager']
        ]);
        Session::flash('successMessage', translate('Updated successfully'));
        return to_route('dashboard.profile.show');
    }
}
