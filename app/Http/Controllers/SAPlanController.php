<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\SACreatePlanRequest;
use App\Http\Requests\UpdatePlanRequest;
use Illuminate\Http\Request;






class SAPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $plans = Plan::with('company')
        ->when($request->name, function ($query, $name) {
            return $query->whereHas('company',  function ($q) use ($name) {
                $q->where('name', $name);
            });
        })->paginate(10);

        if (request()->ajax()) {
            return view('DashboardSuperAdmin.SuperAdmin.plan.Section.indexTable', compact('plans'));
        }
        return view('DashboardSuperAdmin.SuperAdmin.Plan.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('DashboardSuperAdmin.SuperAdmin.Plan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SACreatePlanRequest $request)
    {
        Plan::create(
            [
                'name' => $request->name,
                'trips_number' => $request->trips_number,
                'company_id' => $request->company,
                'type_bus' => $request->bustype,
                'available' => $request->available,
                'price' => $request->price,
                'to' => $request->to,
                'form' => $request->from
            ]
        );
        Session::flash('successMessage', translate('Add successfully'));

        return redirect()->route('SAindex.plan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Plan $plan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $plan = Plan::findOrFail($id);
        return view('DashboardSuperAdmin.SuperAdmin.Plan.edit', compact('plan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SACreatePlanRequest $request, $id)
    {
        $plan = Plan::findOrFail($id);

        $plan->update([
            'company_id' => $request['company'],
            'name' => $request['name'],
            'trips_number' => $request['trips_number'],
            'type_bus' => $request['bustype'],
            'available' => $request['available'],
            'price' => $request['price'],
            'form' => $request['from'],
            'to' => $request['to']

        ]);
        Session::flash('successMessage', translate('Updated successfully'));
        return to_route('SAindex.plan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $plan = Plan::findOrFail($id);
        $plan->delete();
        Session::flash('successMessage', translate('Deleted successfully'));
        return to_route('SAindex.plan');
    }


    public function getPlanDetails(Request $request)
    {
        $plan = Plan::find($request->plan_id);

        if (!$plan) {
            return response()->json([
                'success' => false,
                'message' => 'Trip not found'
            ], 404);
        }


        return response()->json([
            'success' => true,
            'plan' => [
                'id' => $plan->id,
                'name' => $plan->name,
                'trips_number' => $plan->trips_number,
                'type_bus' => $plan->type_bus,
                'price' => $plan->price,
                'to' => $plan->to,
                'form' => $plan->form,
            ],
        ]);
    }
}
