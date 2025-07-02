<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Bus;
use App\Models\Trip;
use App\Models\Company;
use App\Models\Passenger;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;



class TripController extends Controller
{
    //
  /*  public function index()
    {
        $trips = Trip::with(['bus', 'company'])->get();

        return response()->json(['data'=>$trips]);
    }*/

    public function availableSeats($tripId)
{
    $trip = Trip::findOrFail($tripId);

    // اجلب أرقام المقاعد المحجوزة بالفعل لهذه الرحلة
    $reservedSeats = Passenger::whereHas('reservation', function ($q) use ($tripId) {
        $q->where('trip_id', $tripId);
    })->pluck('seat_number');

    // لنفترض عدد المقاعد في الرحلة ثابت (مثلاً 40 كرسي)
    $allSeats = range(1, 40);

    // المقارنة لإخراج الكراسي المتاحة فقط
    $availableSeats = array_diff($allSeats, $reservedSeats->toArray());

    return response()->json([
        'available_seats' => array_values($availableSeats),
    ]);
}

    public function gettrips($trip_id)
{
    $trip = Trip::with(['path', 'bus'])->find($trip_id);

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

public function index()
{
    $trips = Trip::where('company_id', Auth::id())
                 ->whereDate('take_off_at', '>=', Carbon::today())
                 ->with('path')
                 ->paginate(10);

    return response()->json([
        'status' => true,
        'message' => 'تم جلب الرحلات بنجاح',
        'data' => $trips,
    ]);
}
    /* public function show($companyId)
     {dd();
        // $user= Auth::user();
        // user_id==$user->id;
         $companyId->validate([
        'price' => 'required|numeric|min:0',
        'bus_id' => 'required|exists:buses,id',
        'company_id' => 'required|exists:companies,id',
        'take_off_at' => 'required|date|after_or_equal:now',

        ]);

        $trips = Trip::with(['path', 'bus', 'reservation'])
            ->where('company_id', $companyId)
            ->where('take_off_at', '>=', Carbon::now())
            ->get();

        $result = $trips->map(function ($trip) {
            // حساب عدد المقاعد المحجوزة
            $bookedSeats = $trip->reservation->sum('count_seat');
            $totalSeats = $trip->bus->seats ?? 0;
            $availableSeats = $totalSeats - $bookedSeats;

            // معرفة إذا كانت الرحلة سريعة أو متقطعة
            $stops = collect([$trip->path->to2, $trip->path->to3, $trip->path->to4, $trip->path->to5])
                        ->filter()
                        ->count();
            $tripType = $stops > 0 ? 'متقطعة' : 'سريعة';

            return [
                'trip_id' => $trip->id,
                'price' => $trip->price,
                'from' => $trip->path->from,
                'to' => $trip->path->to1, // أو حسب النقطة الأخيرة
                'trip_type' => $tripType,
                'booked_seats' => $bookedSeats,
                'available_seats' => $availableSeats,
                'bus_type' => $trip->bus->type ?? 'غير معروف',
                'departure_time' => $trip->take_off_at->format('Y-m-d H:i'),
            ];
        });

        return response()->json([
            'status' => true,
            'data' => $result,
        ]);
    }

public function store(Request $request)
{
    $data = $request->validate([
        'number' => 'required|string',
        'seats' => 'required|integer',
        'type' => 'required|string',
        'company_id' => 'required|exists:companies,id',
    ]);

    $bus =Bus::create($data);

    return response()->json($bus, 201);
}

 /* protected function calculateArrivalTime($trip, $to)
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
    }*/
}
