<?php

namespace App\Http\Controllers\Api;

use App\Models\Trip;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TripController extends Controller
{
    //
    public function index()
    {
        $trips = Trip::with(['bus', 'company'])->get();

        return response()->json(['data'=>$trips]);
    }
    public function show( Request $request,)
     {
        // $user= Auth::user();
        // user_id==$user->id;
         $request->validate([
        
            'from' => 'required|string|different:to',
            'to' => 'required|string|different:form',
            'to1'=> 'string',
            'to2'=> 'string',
            'to3'=> 'string',
            'to4'=> 'string',
            'to5'=> 'string',
        ]);
        $from = $request->input('from');
        $to = $request->input('to');
 $trips = Trip::whereHas('path', function($query) use ($from, $to) {
                $query->where('from', $from)
                      ->where(function($q) use ($to) {
                          $q->where('to1', $to)
                            ->orWhere('to2', $to)
                            ->orWhere('to3', $to)
                            ->orWhere('to4', $to)
                            ->orWhere('to5', $to);
                      });
            })
             ->where('take_off_at', '>', now($time='take_off_at'))
            ->with(['path', 'reservations', 'bus', 'company'])
            ->get();
            $availableTrips = $trips->map(function($trip) use ($from, $to) {

            $bookedSeats = $trip->reservations->sum('count_seats');


            $stopsCount = 0;
            foreach (['to2', 'to3', 'to4', 'to5'] as $stop) {
                if (!empty($trip->path->$stop)) {
                    $stopsCount++;
                }
            }
            $tripType = $stopsCount > 0 ? 'متقطع' : 'واحد';


            $arrivalTime = $this->calculateArrivalTime($trip, $to);
 return [
                'id' => $trip->id,
                'departure_time' => $trip->take_off_at->format('Y-m-d H:i'),
                'arrival_time' => $arrivalTime?->format('Y-m-d H:i'),
                'available_seats' => $trip->bus->seats - $bookedSeats,
                'booked_seats' => $bookedSeats,
                'trip_type' => $tripType,
                'price' => $trip->price,
                'bus_number' => $trip->bus->number,
                'company_name' => $trip->company->name,
                'from' => $trip->path->from,
                'to' => $to,
                'stops' => $this->getTripStops($trip->path),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $availableTrips,
        ]);
    }

  protected function calculateArrivalTime($trip, $to)
    {
  $path = $trip->path;

        if ($path->to1 === $to) {
            return $trip->take_off_at->addHours();
        } elseif ($path->to2 === $to) {
            return $trip->take_off_at->addHours();
        } elseif ($path->to3 === $to) {
            return $trip->take_off_at->addHours();
        } elseif ($path->to4 === $to) {
            return $trip->take_off_at->addHours();
        } elseif ($path->to5 === $to) {
            return $trip->take_off_at->addHours();
        }

        return null;
    }
    protected function getTripStops($path)
    {
        $stops = [];

        foreach (['to1', 'to2', 'to3', 'to4', 'to5'] as $stop) {
            if (!empty($path->$stop)) {
                $stops[] = $path->$stop;
            }
        }

        return $stops;
    }
}
