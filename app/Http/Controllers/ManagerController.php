<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use App\Http\Requests\CreateManagerRequest;
use App\Http\Requests\UpdateManagerRequest;

use Illuminate\Support\Facades\Session;

class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $managers = Manager::paginate();
        if (request()->ajax()) {
            return view('DashboardSuperAdmin.SuperAdmin.Manager.Section.indexTable', compact('managers'));
        }
        return view('DashboardSuperAdmin.SuperAdmin.Manager.index', compact('managers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('DashboardSuperAdmin.SuperAdmin.Manager.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateManagerRequest $request)
    {
        Manager::insert(
            [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone

            ]
        );
        Session::flash('successMessage', translate('Add successfully'));

        return redirect()->route('manager.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Manager $manager)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $manager = Manager::findOrFail($id);
        return view('DashboardSuperAdmin.SuperAdmin.Manager.edit', compact('manager'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateManagerRequest $request, $id)
    {
        $manager = Manager::findOrFail($id);

        $manager->update([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'phone' => $request['phone']
        ]);
        Session::flash('successMessage', translate('Updated successfully'));
        return to_route('manager.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $manager = Manager::findOrFail($id);
        $manager->delete();
        Session::flash('successMessage', translate('Deleted successfully'));
        return to_route('manager.index');
    }
}
