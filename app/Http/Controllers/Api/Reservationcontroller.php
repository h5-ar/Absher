<?php

namespace App\Http\Controllers\Api;

use App\Models\Trip;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Reservationcontroller extends Controller
{
    // 
    public function store(Request $request)
    {
        //
        $request->validate([
            'trip_id'=>'required|exists:trips,id',
            'count_seats'=>'required |integer|min:1',
        ]);
        $trip =Trip::with('bus')->findOrFail($request -> trip_id );
        if($trip->available_seats < $request ->count_seats){
             return response()->json (['message'=> 'المقاعد المطلوبة غير متوفرة '],400);
        }
        $reservation = Reservation :: create([
            'user_id'=>auth()->id(),
             'trip_id'=>$request->trip_id,
             'count_seats'=>$request->count_seats,
        ]);
        $trip->available_seats -=$request-> count_seats;
        $trip->save();
        return response()-> json(['massege'=> 'تم الحجز بنجاح ','data'=>$reservation],201);
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
     public function edit(Reservation $reservation)
     {

     }


}
