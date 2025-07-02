<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBusRequest;
use App\Http\Requests\UpdateBusRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Bus;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class BusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $buses = Bus::where('Company_id', Auth::id())
            ->when($request->type, function ($query, $type) {
                return $query->where('type', $type);
            })
            ->paginate(10);

        if ($request->ajax()) {
            return view('Dashboard.Admin.Bus.Section.indexTable', compact('buses'));
        }

        return view('Dashboard.Admin.Bus.index', compact('buses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::all();
        return view('Dashboard.Admin.Bus.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateBusRequest $request)
    {

        $companyId = $this->getLoggedInCompanyId();

        Bus::insert(
            [
                'type' => $request->bustype,
                'company_id' => $companyId,
                'seats_count' => $request->seats_count
            ]
        );
        Session::flash('successMessage', translate('add successfully'));

        return redirect()->route('bus.index');
    }

    function getLoggedInCompanyId()
    {
        return Auth::id();
    }



    /**
     * Display the specified resource.
     */
    public function show(Bus $bus) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $bus = Bus::findOrFail($id);
        return view('Dashboard.Admin.Bus.edit', compact('bus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBusRequest $request, $id)
    {
        $bus = Bus::findOrFail($id);

        $bus->update([
            'type' => $request['bustype'],
            'seats_count' => $request['seats_count']
        ]);
        Session::flash('successMessage', translate('updated successfully'));
        return to_route('bus.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $bus = Bus::findOrFail($id);

        $bus->delete();

        Session::flash('successMessage', translate('Deleted successfully'));
        return to_route('bus.index');
    }
}
