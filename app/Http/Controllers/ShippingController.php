<?php

namespace App\Http\Controllers;

use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shipments = Shipping::whereHas('trip', function ($query) {
            $query->where('company_id', Auth::id());
        })->with('trip')->paginate(10);
        if (request()->ajax()) {
            return view(
                'Dashboard.Admin.Shipping.Section.indexTable',
                compact('shipments')
            );
        }
        return view(
            'Dashboard.Admin.Shipping.index',
            compact('shipments')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
                return view('Dashboard.Admin.Shipping.create');

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
    public function show(Shipping $shipping)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shipping $shipping)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shipping $shipping)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shipping $shipping)
    {
        //
    }
}
