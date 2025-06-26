<?php

namespace App\Http\Controllers\Api;

use Illuminate\Validation\Rule;
use App\Models\Trip;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Subscribtion;
use App\Models\Passenger;




class ReservationController extends Controller
{
    //

    public function index()
    {
        
        $reservations = Reservation::with(['trip', 'user'])
            ->where('user_id', auth()->id())
            ->get();

        return response()->json([
            'message' => 'قائمة الحجوزات الخاصة بك',
            'data' => $reservations
        ]);
    }

    public function store(Request $request)
    {
        $syrianGovernorates = [
            'دمشق',
            'ريف دمشق',
            'حلب',
            'حمص',
            'حماة',
            'اللاذقية',
            'طرطوس',
            'درعا',
            'القنيطرة',
            'السويداء',
            'إدلب',
            'الرقة',
            'دير الزور',
            'الحسكة'
        ];

        $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'count_seats' => 'required|integer|min:1',
            'name' => 'required|string|max:255',
            'date' => ['required', 'date', 'after_or_equal:today'],
            'form' => ['required', 'string', 'different:to', Rule::in($syrianGovernorates)],
            'to' => ['required', 'string', 'different:form', Rule::in($syrianGovernorates)],
            'payment_method' => ['required', Rule::in(['cash', 'subscription'])],
        ]);

        $trip = Trip::with('bus')->findOrFail($request->trip_id);
            // $trip->reservation([])
        if ($trip->available_seats < $request->count_seats) {
            return response()->json(['message' => 'المقاعد المطلوبة غير متوفرة'], 400);
        }


        if ($request->payment_method === 'subscription') {
            $subscription = \App\Models\Subscribtion::where('user_id', auth()->id())
                ->where('expires_at', '>=', now())
                ->latest()->first();

            if (!$subscription) {
                return response()->json(['message' => 'لا يوجد اشتراك فعّال'], 403);
            }

            if ($subscription->remaining_trips < $request->count_seats) {
                return response()->json(['message' => 'عدد الرحلات المتبقية في الاشتراك غير كافٍ'], 403);
            }


            $subscription->remaining_trips -= $request->count_seats;
            $subscription->save();
        }

        $reservation = Reservation::create([
            'user_id' => auth()->id(),
            'trip_id' => $request->trip_id,
            'count_seats' => $request->count_seats,
        ]);

        $trip->available_seats -= $request->count_seats;
        $trip->save();
        return response()->json(['massege' => 'تم الحجز بنجاح', 'data' => $reservation], 201);
    }

    public function destroy(Reservation $reservation)
    {
        if (auth()->id() !== $reservation->user_id) {
            return response()->json([
                'message' => 'غير مسموح لك بحذف هذا الحجز'
            ], 403);
        }

        $reservation->delete();

        return response()->json([
            'message' => 'تم حذف الحجز بنجاح'
        ], 200);
    }


    public function Edit(Request $request, $passengerId)
    {
        $request->validate([

            'first_name' => 'sometimes|string|max:255',
            'father_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'seat_number' => 'sometimes|integer|unique:passengers,seat_number,' . $passengerId,

            'count_seats' => 'sometimes|integer|min:1',
        ]);


        $passenger = Passenger::findOrFail($passengerId);

        $passenger->update($request->only(['first_name', 'father_name', 'last_name', 'seat_number']));


        if ($request->has('count_seats')) {
            $reservation = Reservation::findOrFail($passenger->reservation_id);
            $reservation->update(['count_seats' => $request->count_seats]);
        }

        return response()->json([
            'message' => 'تم تعديل بيانات الراكب والحجز بنجاح',
            'passenger' => $passenger,
        ], 200);
    }
}
