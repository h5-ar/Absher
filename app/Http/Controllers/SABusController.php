<?php

namespace App\Http\Controllers;

use App\Http\Requests\SACreateBusRequest;
use App\Http\Requests\SAUpdateBusRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Bus;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class SABusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $buses = Bus::paginate(10);
        if (request()->ajax()) {
            return view('DashboardSuperAdmin.SuperAdmin.Bus.Section.indexTable', compact('buses'));
        }
        return view('DashboardSuperAdmin.SuperAdmin.Bus.index', compact('buses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::all();
        return view('DashboardSuperAdmin.SuperAdmin.Bus.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SACreateBusRequest $request)
    {
        Bus::Create(
            [
                'type' => $request->bustype,
                'company_id' => $request->company,
                'seats_count' => $request->seats_count
            ]
        );
        Session::flash('successMessage', translate('add successfully'));

        return redirect()->route('SAbus.index');
    }

  
    /**
     * Display the specified resource.
     */
    public function show(Bus $bus) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $bus = Bus::findOrFail($id);
        return view('DashboardSuperAdmin.SuperAdmin.Bus.edit', compact('bus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SACreateBusRequest $request, $id)
    {
        $bus = Bus::findOrFail($id);

        $bus->update([
            'type' => $request['bustype'],
            'company_id'=>$request['company'],
            'seats_count' => $request['seats_count']
        ]);
        Session::flash('successMessage', translate('updated successfully'));
        return to_route('SAbus.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $bus = Bus::findOrFail($id);

        $bus->delete();

        Session::flash('successMessage', translate('Deleted successfully'));
        return to_route('SAbus.index');
    }
}
