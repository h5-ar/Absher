<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Requests\CreateSubscription;


class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subscriptions = Subscription::whereHas('plan', function ($query) {
            $query->where('company_id', Auth::id());
        })->with('plan')->paginate(10);
        if (request()->ajax()) {
            return view(
                'Dashboard.Admin.Subscription.Section.indexTable',
                compact('subscriptions')
            );
        }
        return view(
            'Dashboard.Admin.Subscription.index',
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
     * Display the specified resource.
     */
    public function show(Subscription $Subscription)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subscription $Subscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subscription $Subscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
