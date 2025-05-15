<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Models\SuperAdmin;
use Illuminate\Http\Request;
use App\Models\Manager;
use App\Models\Company;


class SuperAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::all();
        $managers = Manager::all();

    
        return view('DashboardSuperAdmin.SuperAdmin.dashboard', compact('managers', 'companies'));
    
    }

    public function switchLang()
    {
        $lang = match (app()->getLocale()) {
            'ar'    => 'en',
            'en'    => 'ar',
        };

        Session::put('lang', $lang);
        return redirect()->route('super_admin.dashboard');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SuperAdmin $superAdmin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuperAdmin $superAdmin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SuperAdmin $superAdmin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuperAdmin $superAdmin)
    {
        //
    }
}
