<?php

namespace App\Http\Controllers;

use App\Models\Passenger;
use Illuminate\Http\Request;
use App\Http\Requests\CreatePassengerRequest;

use Illuminate\Support\Facades\Session;

use App\Models\Reservation;



class SAPassengerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(Passenger $passenger)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $passenger = Passenger::with(['trip'])->findOrFail($id);
        $stations = [
            'from' => $passenger->reservation->trip->path->from,
            'to1' => $passenger->reservation->trip->path->to1,
            'to2' => $passenger->reservation->trip->path->to2,
            'to3' => $passenger->reservation->trip->path->to3,
            'to4' => $passenger->reservation->trip->path->to4,
            'to5' => $passenger->reservation->trip->path->to5,
            'last_destination' => $passenger->reservation->trip->path->last_destination
        ];

        // إزالة القيم الفارغة والمكررة
        $uniqueStations = array_unique(array_filter($stations));

        return view(
            'DashboardSuperAdmin.SuperAdmin.Passenger.edit',
            [
                'passenger' => $passenger,
                'stations' => $uniqueStations
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreatePassengerRequest $request, $id)
    {
        $passenger = Passenger::findOrFail($id);

        $passenger->update([
            'National_number' => $passenger['National_number'],
            'first_name' => $request['first_name'],
            'father_name' => $request['father_name'],
            'last_name' => $request['last_name'],
            'from' => $request['departure_point'],
            'to' => $request['arrival_point'],
            'seat_number' => $request['seat_number']


        ]);
        Session::flash('successMessage', translate('Updated successfully'));
        return to_route('SAindex.reservation');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, $reservation_id)
    {

        // العثور على المسافر والحجز مع التحقق من وجودهم
        $passenger = Passenger::where('id', $id)
            ->where('reservation_id', $reservation_id)
            ->firstOrFail();

        $reservation = Reservation::findOrFail($reservation_id);

        // التحقق من عدد المقاعد المتبقية
        $remainingPassengers = Passenger::where('reservation_id', $reservation_id)->count();

        if ($remainingPassengers == 1) {
            // إذا لم يعد هناك ركاب، احذف الحجز بالكامل
            $reservation->passengers()->delete();
            $reservation->delete();
        } else {
            // إذا بقي ركاب، قلل عدد المقاعد فقط
            $reservation->update([
                'count_seats' => $reservation->count_seats - 1,
            ]);
        }

        // حذف المسافر أولاً
        $passenger->delete();


        Session::flash('successMessage', translate('Deleted successfully'));
        return redirect()->route('SAindex.reservation');
    }
}
