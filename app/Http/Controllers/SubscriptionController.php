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
        return view(
            'Dashboard.Admin.Subscription.create'
        );
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateSubscription $request)
    {

        $plan = Plan::findOrFail($request->plan_id);

        Subscription::create([
            'plan_id' => $request->plan_id,
            'rest_trips' => $plan->trips_number,
            'start_at' => Carbon::now(),
            'end_at' => Carbon::now()->addDays(30),
            'booking_source' => 'wep',
        ]);

        Session::flash('successMessage', translate('Added successfully'));

        return redirect()->route('index.subscription');
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
        $subscription = Subscription::findOrFail($id);

        $subscription->delete();
        Session::flash('successMessage', translate('Deleted successfully'));
        return to_route('index.subscription');
    }
}
