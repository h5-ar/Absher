<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;

class SASubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
    {
        $subscriptions = Subscription::with('plan')->paginate(10);
        if (request()->ajax()) {
            return view(
                'DashboardSuperAdmin.SuperAdmin.Subscription.Section.indexTable',
                compact('subscriptions')
            );
        }
        return view(
            'DashboardSuperAdmin.SuperAdmin.Subscription.index',
            compact('subscriptions')
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
}
