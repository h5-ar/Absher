<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Passenger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::where('company_id', Auth::id())->paginate(10);
        if (request()->ajax()) {
            return view('Dashboard.Admin.Reservation.Section.indexTable', compact('reservations'));
        }
        return view('Dashboard.Admin.Reservation.index', compact('reservations'));
    }
    public function passengers(Request $request)
    {
        $reservationId = $request->input('reservation_id');

        $passengers = Passenger::where('reservation_id', $reservationId)
            ->select('id','reservation_id', 'first_name', 'father_name', 'last_name', 'seat_number', 'from', 'to')
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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

        $reservation->passenger()->delete();
        $reservation->delete();
        Session::flash('successMessage', translate('Deleted successfully'));
        return to_route('index.reservation');
    }
}
