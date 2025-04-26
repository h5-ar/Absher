<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Company;

use App\Models\Path;
use App\Models\Bus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\SACreateTripVehicleRequest;
use App\Http\Requests\SACreateTripQuickRequest;
use App\Http\Requests\SAUpdateTripRequest;



use Illuminate\Http\Request;

class SATripController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trips = Trip::paginate(10);
        if (request()->ajax()) {
            return view(
                'DashboardSuperAdmin.SuperAdmin.Trip.Section.indexTable',
                compact('trips')
            );
        }
        return view(
            'DashboardSuperAdmin.SuperAdmin.Trip.index',
            compact('trips')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createQuick()
    {
        $buses = Bus::all();

        return view('DashboardSuperAdmin.SuperAdmin.Trip.createQuick', compact('buses'));
    }
    public function createVehicle()
    {
        $buses = Bus::all();
        return view('DashboardSuperAdmin.SuperAdmin.Trip.createVehicle', compact('buses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeQuick(SACreateTripQuickRequest $request)
    {
        $tripId = Trip::insertGetId([
            'company_id'=>$request->company,

            'price' => $request->price,
            'bus_id' => $request->Bus,
            'take_off_at' => date('Y-m-d H:i:s', strtotime($request->datetime)),
            'day' => $request->day

        ]);

        Path::create([
            'from' => $request->from,
            'to1' => $request->to,
            'trip_id' => $tripId
        ]);
        Session::flash('successMessage', translate('Add successfully'));

        return redirect()->route('index');
    }
    public function storeVehicle(SACreateTripVehicleRequest $request)
    {
        $tripId = Trip::insertGetId([
            'company_id'=>$request->company,
            'price' => $request->price,
            'bus_id' => $request->Bus,
            'take_off_at' => date('Y-m-d H:i:s', strtotime($request->datetime)),
            'day' => $request->day
        ]);

        Path::create([
            'from' => $request->from,
            'to1' => $request->to1,
            'to2' => $request->to2,
            'to3' => $request->to3,
            'to4' => $request->to4,
            'to5' => $request->to5,
            'trip_id' => $tripId
        ]);
        Session::flash('successMessage', translate('Add successfully'));

        return redirect()->route('index');
    }



    /**
     * Display the specified resource.
     */
    public function show(Trip $trip)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        
        $trip = Trip::with('path')->findOrFail($id);
        $buses = Bus::all();
        $companies=Company::all();
        return view('DashboardSuperAdmin.SuperAdmin.Trip.edit', compact('trip', 'buses','companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SAUpdateTripRequest $request, string $tripId)
    {
        $trip = Trip::findOrFail($tripId);

        $trip->update([
            'company_id'=>$request['company'],

            'price' => $request['price'],
            'bus_id' => $request['Bus'],
            'take_off_at' => date('Y-m-d H:i:s', strtotime($request['datetime'])),
            'day' => $request['day']

        ]);
        $trip->path()->update([
            'from' => $request['from'],
            'to1' => $request['to1'],
            'to2' => $request['to2'],
            'to3' => $request['to3'],
            'to4' => $request['to4'],
            'to5' => $request['to5']
        ]);
        Session::flash('successMessage', translate('updated successfully'));

        return to_route('index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $trip = Trip::findOrFail($id);
        $trip->path()->delete();
        $trip->delete();
        Session::flash('successMessage', translate('Deleted successfully'));
        return to_route('index');
    }
}
