<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\CreatePlanRequest;
use App\Http\Requests\UpdatePlanRequest;





class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plans = Plan::paginate();
        if (request()->ajax()) {
            return view('Dashboard.Admin.plan.Section.indexTable', compact('plans'));
        }
        return view('Dashboard.Admin.Plan.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Dashboard.Admin.Plan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePlanRequest $request)
    {
        $companyId = $this->getLoggedInCompanyId();
        Plan::insert(
            [
                'name' => $request->name,
                'trips_number' => $request->trips_number,
                'company_id' => $companyId,
                'type_bus' => $request->bustype,
                'available' => $request->available,
                'price' => $request->price,
                'to' => $request->to,
                'form' => $request->from

            ]
        );
        Session::flash('successMessage', translate('Add successfully'));

        return redirect()->route('index.plan');
    }
    function getLoggedInCompanyId()
    {
        return Auth::id();
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
        return view('Dashboard.Admin.Plan.edit', compact('plan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePlanRequest $request, $id)
    {
        $plan = Plan::findOrFail($id);

        $plan->update([
            'name' => $request['name'],
            'trips_number' => $request['trips_number'],
            'type_bus' => $request['bustype'],
            'available' => $request['available'],
            'price' => $request['price'],
            'form' => $request['from'],
            'to' => $request['to']

        ]);
        Session::flash('successMessage', translate('Updated successfully'));
        return to_route('index.plan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $plan = Plan::findOrFail($id);
        $plan->delete();
        Session::flash('successMessage', translate('Deleted successfully'));
        return to_route('index.plan');
    }
}
