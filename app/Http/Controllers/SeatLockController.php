<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
 use Carbon\Carbon;
use App\Models\SeatLock;


class SeatLockController extends Controller
{
    //

public function lock(Request $request, $tripId)
{
    $request->validate([
        'seat_number' => 'required|integer',
    ]);

    $seatNumber = $request->seat_number;

    // مدة القفل المؤقت
    $lockDuration = 3; // بالدقائق

    // تحقق إن كان الكرسي محجوز مسبقاً
    $existingLock = SeatLock::where('trip_id', $tripId)
        ->where('seat_number', $seatNumber)
        ->where('locked_at', '>', Carbon::now()->subMinutes($lockDuration))
        ->first();

    if ($existingLock) {
        return response()->json(['message' => 'This seat is already locked'], 409);
    }

    // خزّن القفل الجديد
    SeatLock::updateOrCreate(
        ['trip_id' => $tripId, 'seat_number' => $seatNumber],
        [
            'user_id' => auth()->id(),
            'locked_at' => Carbon::now(),
        ]
    );

    return response()->json(['message' => 'Seat locked successfully']);
}

}
