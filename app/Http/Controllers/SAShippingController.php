<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemShipping;
use App\Models\Shipping;

class SAShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $shipments = Shipping::with('trip')->paginate(10);
        if (request()->ajax()) {
            return view(
                'DashboardSuperAdmin.SuperAdmin.Shipping.Section.indexTable',
                compact('shipments')
            );
        }
        return view(
            'DashboardSuperAdmin.SuperAdmin.Shipping.index',
            compact('shipments')
        );
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
     public function getItem(Request $request)
    {
        $shipmentId = $request->shipment_id;
        $items = ItemShipping::where('shipping_id', $shipmentId)
            ->get();

        return response()->json([
            'success' => true,
            'items' => $items
        ]);
    }
}
