<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Passenger;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\CreateAdminReservation;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $reservations = Reservation::where('company_id', Auth::id())
            ->with('passengers')
            ->paginate(10);
        if (request()->ajax()) {
            return view('Dashboard.Admin.Reservation.Section.indexTable', compact('reservations'));
        }
        return view('Dashboard.Admin.Reservation.index', compact('reservations'));
    }
    public function passengers(Request $request)
    {
        $reservationId = $request->input('reservation_id');

        $passengers = Passenger::where('reservation_id', $reservationId)
            ->select('id', 'reservation_id', 'first_name', 'father_name', 'last_name', 'seat_number', 'from', 'to')
            ->get();

        return response()->json([
            'success' => true,
            'passengers' => $passengers
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Dashboard.Admin.Reservation.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeAdmin(CreateAdminReservation $request)
    {
        $reservationId = Reservation::insertGetId([
            'trip_id' => $request->trip_id,
            'count_seats' => $request->seats_count,
            'company_id' => auth()->id(),
            'booking_source' => 'web',
        ]);
        $trip = Trip::findOrFail($request->trip_id);
        foreach ($request->passengers as $passenger) {
            $passengerr = Passenger::create([
                'reservation_id' => $reservationId,
                'first_name' => $passenger['first_name'],
                'father_name' => $passenger['father_name'],
                'last_name' => $passenger['last_name'],
                'seat_number' => $passenger['seat_number'],
                'subscribtion_id' => $passenger['subscribtion_id'] ?? null,
                'from' => $trip->path->from,
                'to' => $trip->path->getLastDestinationAttribute()
            ]);
        }

        return redirect()->route('index.reservation');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        //
        // $Reservation=Reservation:: get();
        // return view ('reservation.index',compact('reservation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $reservation = Reservation::findOrFail($id);
        return view('Dashboard.Admin.Reservation.edit', compact('reservation'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        $reservation->update([

            'count_seats' => $request['count_seats'],

        ]);
        Session::flash('successMessage', translate('Updated successfully'));
        return to_route('index.reservation');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);

        $reservation->passengers()->delete();
        $reservation->delete();
        Session::flash('successMessage', translate('Deleted successfully'));
        return to_route('index.reservation');
    }

    public function getTripsForSelection()
    {
        $trips = Trip::select(
            'id',
            'from',
            'to',
            'departure_date as date',
            'available_seats'
        )->get();

        return response()->json($trips);
    }

    public function getTrips()
    {
        $trips = Trip::select(
            'id',
            'from',
            'to',
            'departure_date as date',
            'available_seats'
        )->get();

        return response()->json($trips);
    }


}
