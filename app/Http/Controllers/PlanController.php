<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\CreatePlanRequest;
use App\Http\Requests\UpdatePlanRequest;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CreatePlanNotification;





class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $plans = Plan::query()
            ->when($request->name, function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
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
        $plan = Plan::create(
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

        $company = Company::where('id', Auth::id())->first();
        $user = User::get();

        Notification::send($user, new CreatePlanNotification($company, $plan));

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
    public function getAllPlan()
    {
        $plans = Plan::where('Company_id', Auth::id())->get();
        return response()->json(['plans' => $plans]);
    }
}
