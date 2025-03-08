<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;  // إضافة هذه السطر
use App\Models\Bus;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;

class BusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Dashboard.Admin.Bus.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::all();
        return view('Dashboard.Admin.Bus.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // هنا تحصل على ID الشركة من الجلسة
        $companyId = Auth::user()->company_id;  // تصحيح هنا
        Bus::insert(
            [
                'type' => $request->type,
                'company_id' => $companyId,  // استخدام الاسم الصحيح للعمود
                'seats_count' => $request->seats_count
            ]
        );
        return redirect()->route('bus.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(Bus $bus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bus $bus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bus $bus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bus $bus)
    {
        //
    }
}
