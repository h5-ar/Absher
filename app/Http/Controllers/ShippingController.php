<?php

namespace App\Http\Controllers;

use App\Models\ItemShipping;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


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
    public function show(Shipping $shipping)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit($id)
    {

        $shipment = Shipping::findOrFail($id);

        return view('Dashboard.Admin.Shipping.edit', compact('shipment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $plan = Shipping::findOrFail($id);

        $plan->update([
            'shipment_status' => $request['shipment_status'],
        ]);
        Session::flash('successMessage', translate('Updated successfully'));
        return to_route('index.shipping');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shipping $shipping)
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
