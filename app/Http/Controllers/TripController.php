<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return 34;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Dashboard.Admin.Trip.create');
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
    public function show(Trip $trip)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Trip $trip)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Trip $trip)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trip $trip)
    {
        //
    }
    public function getTripByData($serchData)
    {
        $trip = Trip::whereDate('take_off_at',$serchData)->get();
        return response()->json($trip);
    }  


    public function getTripByCompany ($compoany)
    {
        $trip = Trip:: where('company',$compoany)->get();
        return response()->json($trip);
    }

      
public function getTripByCompanyAndDate ($compoany,$serchData)
    {
        $trip = Trip:: where('company',$compoany)->whereDate('take_off_at',$serchData)->get();
        return response()->json($trip);
    }

}
 