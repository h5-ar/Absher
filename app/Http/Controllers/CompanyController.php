<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\CreateCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $companies = Company::when($request->name, function ($query, $name) {
            return $query->where('name', $name);
        })->paginate(10);
        if (request()->ajax()) {
            return view('DashboardSuperAdmin.SuperAdmin.Comapny.Section.indexTable', compact('companies'));
        }
        return view('DashboardSuperAdmin.SuperAdmin.Company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('DashboardSuperAdmin.SuperAdmin.Company.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCompanyRequest $request)
    {
        Company::insert(
            [

                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->input('password')),
                'Description' => $request->description,
                'manager_id' => $request->manager
            ]
        );
        Session::flash('successMessage', translate('Add successfully'));

        return redirect()->route('company.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $company = Company::findOrFail($id);
        return view('DashboardSuperAdmin.SuperAdmin.Company.edit', compact('company'));
    }


    /**
     * Update the specified resource in storage.
     */


    public function update(UpdateCompanyRequest $request, $id)
    {
        $company = Company::findOrFail($id);

        $company->update([
            'name' => $request['name'],
            'phone' => $request['phone'],
            'email' => $request['email'],
            'username' => $request['username'],
            'password' => Hash::make($request->input('password')),
            'Description' => $request['description'],
            'manager_id' => $request['manager']
        ]);
        Session::flash('successMessage', translate('Updated successfully'));
        return to_route('company.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $company = Company::findOrFail($id);
    
        $company->delete();
        Session::flash('successMessage', translate('Deleted successfully'));
        return to_route('company.index');
    }

    public function getCompanyDetails(Request $request)
    {
        $company = Company::find($request->company_id);

        if (!$company) {
            return response()->json([
                'success' => false,
                'message' => 'Company not found'
            ]);
        }
        return response()->json([
            'success' => true,
            'company' => [
                'id' => $company->id,
                'name' => $company->name,
                'phone' => $company->phone,
                'email' => $company->email,
                'username' => $company->username,
                'description' => $company->Description,
                'managerFN' => $company->manager->first_name,
                'managerLN' => $company->manager->last_name,

            ],
        ]);
    }
}
