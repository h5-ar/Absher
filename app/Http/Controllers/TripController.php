<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Path;
use App\Models\Bus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\CreateTripVehicleRequest;
use App\Http\Requests\CreateTripQuickRequest;
use App\Http\Requests\UpdateTripRequest;
use Illuminate\Http\Request;
use App\Http\Requests\UpdatePlanRequest;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CreateTripNotification;
use App\Models\Company;
use App\Models\User;


class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getTripDetails(Request $request)
    {
        $trip = Trip::with(['path', 'bus'])->find($request->trip_id);

        if (!$trip) {
            return response()->json([
                'success' => false,
                'message' => 'Trip not found'
            ], 404);
        }


        return response()->json([
            'success' => true,
            'trip' => [
                'id' => $trip->id,
                'from' => $trip->path->from,
                'to' => $trip->path->getLastDestinationAttribute(),
                'date' => $trip->take_off_at,
                'day' => $trip->day,
                'bus_number' => $trip->bus_id,
                'price' => $trip->price,
            ],
        ]);
    }


    public function index(Request $request)
    {
        $trips = Trip::where('Company_id', Auth::id())
            ->when($request->day, function ($query, $day) {
                return $query->where('day', $day);
            })
            ->when($request->governorate, function ($query, $governorate) {
                return $query->whereHas('path', function ($q) use ($governorate) {
                    $q->where('from', $governorate)
                        ->orWhere('to1', $governorate)
                        ->orWhere('to2', $governorate)
                        ->orWhere('to3', $governorate)
                        ->orWhere('to4', $governorate)
                        ->orWhere('to5', $governorate);
                });
            })
            ->with('path')
            ->paginate(10);

        if ($request->ajax()) {
            return view('Dashboard.Admin.Trip.Section.indexTable', compact('trips'));
        }

        return view('Dashboard.Admin.Trip.index', compact('trips'));
    }
    public function filterTrip(Request $request)
    {
        return $this->index($request);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function createQuick()
    {
$buses = Bus::where('Company_id', Auth::id())->get();
        return view('Dashboard.Admin.Trip.createQuick', compact('buses'));
    }
    public function createVehicle()
    {
$buses = Bus::where('Company_id', Auth::id())->get();
        return view('Dashboard.Admin.Trip.createVehicle', compact('buses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeQuick(CreateTripQuickRequest $request)
    {
        $companyId = $this->getLoggedInCompanyId();
        $tripId = Trip::insertGetId([
            'price' => $request->price,
            'bus_id' => $request->Bus,
            'company_id' => $companyId,
            'take_off_at' => date('Y-m-d H:i:s', strtotime($request->datetime)),
            'day' => $request->day

        ]);

        Path::insert([
                        'type' => $request->type,

            'from' => $request->from,
            'to1' => $request->to,
            'trip_id' => $tripId
        ]);

        $trip = Trip::where('id', $tripId);
        $company = Company::where('id', Auth::id())->first();
        $user = User::get();

        Notification::send($user, new CreateTripNotification($company, $trip));

        Session::flash('successMessage', translate('Add successfully'));

        return redirect()->route('trip.index');
    }
    public function storeVehicle(CreateTripVehicleRequest $request)
    {
        $companyId = $this->getLoggedInCompanyId();
        $tripId = Trip::insertGetId([
            'price' => $request->price,
            'bus_id' => $request->Bus,
            'company_id' => $companyId,
            'take_off_at' => date('Y-m-d H:i:s', strtotime($request->datetime)),
            'day' => $request->day
        ]);

        Path::insert([
                        'type' => $request->type,
            'from' => $request->from,
            'to1' => $request->to1,
            'to2' => $request->to2,
            'to3' => $request->to3,
            'to4' => $request->to4,
            'to5' => $request->to5,
            'trip_id' => $tripId
        ]);

        $trip = Trip::where('id', $tripId);
        $company = Company::where('id', Auth::id())->first();
        $user = User::get();

        Notification::send($user, new CreateTripNotification($company, $trip));

        Session::flash('successMessage', translate('Add successfully'));

        return redirect()->route('trip.index');
    }

    function getLoggedInCompanyId()
    {
        return Auth::id();
    }

    /**
     * Display the specified resource.
     */
    public function show($id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $trip = Trip::with('path')->findOrFail($id);
        $buses = Bus::all();
        return view('Dashboard.Admin.Trip.edit', compact('trip', 'buses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTripRequest $request, string $tripId)
    {
        $trip = Trip::findOrFail($tripId);


        $trip->update([
            'price' => $request['price'],
            'bus_id' => $request['Bus'],
            'take_off_at' => date('Y-m-d H:i:s', strtotime($request['datetime'])),
            'day' => $request['day']

        ]);
        $trip->path()->update([
            'from' => $request['from'],
            'to1' => $request['to1'],
            'to2' => $request['to2'],
            'to3' => $request['to3'],
            'to4' => $request['to4'],
            'to5' => $request['to5']
        ]);
        Session::flash('successMessage', translate('updated successfully'));

        return to_route('trip.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $trip = Trip::with(['reservations.passengers', 'shipping', 'path'])->findOrFail($id);
        foreach ($trip->reservation as $reservation) {
            $reservation->passengers()->delete();
        }
        $trip->reservation()->delete();
        $trip->shipping()->delete();

        $trip->path()->delete();
        $trip->delete();
        Session::flash('successMessage', translate('Deleted successfully'));
        return to_route('trip.index');
    }

    public function filter(Request $request)
    {
        $type = $request->query('type', 'quick'); // القيمة الافتراضية 'quick'

        $today = now()->format('Y-m-d'); // تاريخ اليوم

        $trips = Trip::where('Company_id', Auth::id())
            ->with('path')
            ->whereHas('path', function ($query) use ($type) {
                if ($type === 'vehicle') {
                    $query->whereNotNull('to2'); // رحلات مركبة
                } else {
                    $query->whereNull('to2'); // رحلات مباشرة
                }
            })
            ->whereDate('take_off_at', '>=', $today) // إضافة شرط تاريخ الانطلاق من اليوم فصاعدًا
            ->get();


        return response()->json(['trips' => $trips]);
    }
}
