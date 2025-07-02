<?php

namespace App\Http\Controllers\Api;

use Illuminate\Validation\Rule;
use App\Models\Trip;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\Passenger;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class ReservationController extends Controller
{

    //  public function sttore(Request $request ,$companyId)
    // {
    //      $syrianGovernorates = [
    //         'دمشق',
    //         'ريف دمشق',
    //         'حلب',
    //         'حمص',
    //         'حماة',
    //         'اللاذقية',
    //         'طرطوس',
    //         'درعا',
    //         'القنيطرة',
    //         'السويداء',
    //         'إدلب',
    //         'الرقة',
    //         'دير الزور',
    //         'الحسكة'
    //     ];

    //     $data = $request->validate([
    //         'trip_id' => 'required|exists:trips,id',
    //         'count_seats' => 'required|integer|min:1',
    //         'paidwy' => 'required|in:cach,subscription',
    //          'payment_method' => ['required', Rule::in(['cach', 'subscription'])],
    //         'passengers' => 'required|array|min:1',
    //         'passengers.*.first_name' => 'required|string',
    //         'passengers.*.father_name' => 'required|string',
    //         'passengers.*.last_name' => 'required|string',
    //         'passengers.*.National_number' => 'required|numeric|digits:11',
    //         'passengers.*.seat_number' => 'required|integer',
    //         'passengers.*.from' => ['required', 'string', 'different:to', Rule::in($syrianGovernorates)],
    //         'passengers.*.to' => ['required', 'string', 'different:form', Rule::in($syrianGovernorates)],

    //     ]);
    //      $userId = $request->user_id;

    //     $trip = Trip::findOrFail($data['trip_id']);

    //     if ($data['paidwy'] === 'subscription') {
    //         $subscription = Subscription::where('user_id', $userId)
    //             ->where('rest_trips', '>=', $data['count_seats'])
    //             ->where('end_at', '>=', now())
    //             ->first();

    //         if (!$subscription) {
    //             return response()->json(['message' => 'اشتراك غير صالح أو لا يكفي.'], 422);
    //         }
    //     }

    //     $reservation = Reservation::create([
    //        // 'user_id' => Auth::id(),
    //        'user_id' => $data['user_id'],
    //         'trip_id' => $data['trip_id'],
    //         'count_seats' => $data['count_seats'],
    //         'paidwy' => $data['paidwy'],
    //     ]);

    //     foreach ($data['passengers'] as $passenger) {
    //         Passenger::create([
    //             'reservation_id' => $reservation->id,
    //             'first_name' => $passenger['first_name'],
    //             'father_name' => $passenger['father_name'],
    //             'last_name' => $passenger['last_name'],
    //             'National_number' => $passenger['National_number'],
    //             'seat_number' => $passenger['seat_number'],
    //             'from' => $passenger['from'],
    //             'to' => $passenger['to'],
    //             'subscription_id' => $data['paidwy'] === 'subscription' ? $subscription->id : null,
    //         ]);
    //     }

    //     if (isset($subscription)) {
    //         $subscription->decrement('rest_trips', $data['count_seats']);
    //     }

    //     return response()->json(['message' => 'تم الحجز بنجاح', 'reservation_id' => $reservation->id], 201);
    // }

    public function update(Request $request, $id)
    {
        $userId = $request->user_id;
        $reservation = Reservation::where('id', $id)->where('user_id', $userId)->firstOrFail();

        $data = $request->validate([
            'count_seats' => 'sometimes|integer|min:1',
            'passengers' => 'sometimes|array',
            'passengers.*.id' => 'required|exists:passengers,id',
            'passengers.*.first_name' => 'sometimes|string',
            'passengers.*.father_name' => 'sometimes|string',
            'passengers.*.last_name' => 'sometimes|string',
            'passengers.*.National_number' => 'sometimes|numeric|digits:11',
            'passengers.*.seat_number' => 'sometimes|integer',
            'passengers.*.from' => 'sometimes|string',
            'passengers.*.to' => 'sometimes|string',
        ]);

        if (isset($data['count_seats'])) {
            $reservation->update(['count_seats' => $data['count_seats']]);
        }

        if (isset($data['passengers'])) {
            foreach ($data['passengers'] as $passengerData) {
                Passenger::where('id', $passengerData['id'])
                    ->where('reservation_id', $reservation->id)
                    ->update($passengerData);
            }
        }

        return response()->json(['message' => 'تم التعديل بنجاح']);
     }
public function esraa_Reservations(Request $request,$userId )
{
    $userId = $request->user_id;
    $reservations = Reservation::where('user_id', $userId)
        ->with(['trip.company', 'trip.path', 'passengers']) // جلب الشركة، المسار، الركاب
        ->latest()
        ->get();

    $data = $reservations->map(function ($reservation) {
        $trip = $reservation->trip;
        $path = $trip->path;

        // تأكد من أن المسار موجود و يحتوي على to1
        if (!$path || !$path->to1) {
            return null; // تجاهل الحجز إذا لم يكن path موجود أو to1 فارغة
        }

        $companyName = $trip->company->name ?? 'غير معروف';
        $from = $path->from ?? 'غير معروف';
        $to = collect([
            $path->to1,
            $path->to2,
            $path->to3,
            $path->to4,
            $path->to5,
        ])->filter()->values()->all();

        $seatNumbers = $reservation->passengers->pluck('seat_number')->filter()->values();

        return [
            'reservation_id' => $reservation->id,
            'trip_id' => $trip->id,
            'company_name' => $companyName,
            'from' => $from,
            'to' => $to,
            'take_off_at' => $trip->take_off_at,
            'seat_numbers' => $seatNumbers,
        ];
    })->filter()->values(); // حذف العناصر null الناتجة عن الرحلات غير الصالحة

    return response()->json(['reservations' => $data]);
}



    public function destroy(Request $request,$reservationId, $userId)
{

    $reservation = Reservation::findOrFail($reservationId);

    // التحقق: هل مضى أكثر من 24 ساعة؟
    $createdAt = Carbon::parse($reservation->created_at);
    if ($createdAt->diffInHours(now()) > 24) {
        return response()->json([
            'success' => false,
            'message' => 'لا يمكن حذف الاشتراك بعد مرور 24 ساعة من تفعيله.'
        ], 403);
    }


     $reservation->passengers()->delete();
    // حذف الاشتراك
    $reservation->delete();

    return response()->json([
        'success' => true,
        'message' => 'تم حذف الحجز  بنجاح.'
    ]);
    // $userId = $request->request('user_id');

    // if (!$userId) {
    //     return response()->json(['message' => 'user_id مطلوب'], 400);
    // }

    // $reservation = Reservation::where('id', $userId)
    //     ->where('user_id', $userId)
    //     ->with('trip')
    //     ->first();

    // if (!$reservation) {
    //     return response()->json(['message' => 'الحجز غير موجود أو لا يخص هذا المستخدم'], 404);
    // }

    // $timeNow = Carbon::now();
    // $tripTime = Carbon::parse($reservation->trip->take_off_at);

    // if ($tripTime->diffInHours($timeNow) < 4) {
    //     return response()->json(['message' => 'لا يمكن إلغاء الحجز قبل 4 ساعات من موعد الرحلة'], 403);
    // }

    // $reservation->delete();

    // return response()->json(['message' => 'تم إلغاء الحجز بنجاح']);
}

public function myReservations(Request $request)
 {
//     $userId = $request->input('user_id');

//     if (!$userId) {
//         return response()->json(['message' => 'user_id مطلوب'], 400);
//     }

//     $reservations = Reservation::where('user_id', $userId)
//         ->with(['trip', 'passengers'])
//         ->latest()
//         ->get();

//     return response()->json(['reservations' => $reservations]);
 $user = $request->user(); // المستخدم الحالي من التوكين

    $reservations = Reservation::with(['trip', 'passengers'])
        ->where('user_id', $user->id)
        ->latest()
        ->get();

    return response()->json([
        'success' => true,
        'message' => 'حجوزات المستخدم',
        'data' => $reservations
    ]);
}


public function esstore(Request $request)
{
//     $syrianGovernorates = [
//         'دمشق', 'ريف دمشق', 'حلب', 'حمص', 'حماة', 'اللاذقية',
//         'طرطوس', 'درعا', 'القنيطرة', 'السويداء', 'إدلب',
//         'الرقة', 'دير الزور', 'الحسكة'
//     ];

//     // جلب user_id من الطلب أو التوكن أو المتغير الجاهز
//     $userId = $request->input('user_id'); // لو عم يجيك تلقائي من التطبيق، خليه يمرر هيك

//     // ✅ التحقق من البيانات
//     $data = $request->validate([
//         'trip_id' => 'required|exists:trips,id',
//         'count_seats' => 'required|integer|min:1',
//         'paidwy' => ['required', Rule::in(['cach', 'subscription'])],
//         'passengers' => 'required|array|min:1',
//         'passengers.*.first_name' => 'required|string',
//         'passengers.*.father_name' => 'required|string',
//         'passengers.*.last_name' => 'required|string',
//         'passengers.*.National_number' => 'required|numeric|digits:11|unique:passengers,National_number',
//         'passengers.*.seat_number' => 'required|integer|unique:passengers,seat_number',
//         'passengers.*.from' => ['required', 'string', Rule::in($syrianGovernorates)],
//         'passengers.*.to' => ['required', 'string', Rule::in($syrianGovernorates)],
//     ]);

//     $trip = Trip::findOrFail($data['trip_id']);

//     // ✅ التحقق من الاشتراك في حال الدفع بالاشتراك
//     $subscription = null;
//     if ($data['paidwy'] === 'subscription') {
//         $subscription = Subscription::where('user_id', $userId)
//             ->where('rest_trips', '>=', $data['count_seats'])
//             ->where('end_at', '>=', now())
//             ->first();

//         if (!$subscription) {
//             return response()->json(['message' => 'لا يوجد اشتراك صالح أو عدد الرحلات المتبقية غير كافٍ.'], 422);
//         }
//     }

//     // ✅ إنشاء الحجز
//     $reservation = Reservation::create([
//         'user_id' => $userId,
//         'trip_id' => $data['trip_id'],
//         'count_seats' => $data['count_seats'],
//         'paidwy' => $data['paidwy'],
//     ]);

//     // ✅ إنشاء الركاب
//     foreach ($data['passengers'] as $passenger) {
//         Passenger::create([
//             'reservation_id' => $reservation->id,
//             'first_name' => $passenger['first_name'],
//             'father_name' => $passenger['father_name'],
//             'last_name' => $passenger['last_name'],
//             'National_number' => $passenger['National_number'],
//             'seat_number' => $passenger['seat_number'],
//             'from' => $passenger['from'],
//             'to' => $passenger['to'],
//             'subscription_id' => $subscription?->id, // nullable
//         ]);
//     }

//     // ✅ خصم عدد الرحلات في حال الاشتراك
//     if ($subscription) {
//         $subscription->decrement('rest_trips', $data['count_seats']);
//     }

//     return response()->json([
//         'message' => 'تم الحجز بنجاح',
//         'reservation_id' => $reservation->id
//     ], 201);

$syrianGovernorates = [
        'دمشق', 'ريف دمشق', 'حلب', 'حمص', 'حماة', 'اللاذقية',
        'طرطوس', 'درعا', 'القنيطرة', 'السويداء', 'إدلب',
        'الرقة', 'دير الزور', 'الحسكة'
    ];

    $userId = $request->input('user_id');

    $data = $request->validate([
        'trip_id' => 'required|exists:trips,id',
        'passengers' => 'required|array|min:1',
        'passengers.*.first_name' => 'required|string',
        'passengers.*.father_name' => 'required|string',
        'passengers.*.last_name' => 'required|string',
        'passengers.*.National_number' => 'required|numeric|digits:11|unique:passengers,National_number',
        'passengers.*.seat_number' => 'required|integer',//
        'passengers.*.from' => ['required', 'string', Rule::in($syrianGovernorates)],
        'passengers.*.to' => ['required', 'string', Rule::in($syrianGovernorates)],
    ]);

    $trip = Trip::findOrFail($data['trip_id']);
    $seatsRequested = count($data['passengers']);
    // تحقق من توفر المقاعد
if ($trip->available_seats < $seatsRequested) {
    return response()->json([
        'message' => 'عدد المقاعد المتاحة غير كافٍ لهذه الرحلة.',
        'available_seats' => $trip->available_seats
    ], 400);
}

    // إنشاء الحجز العام
    $reservation = Reservation::create([
        'user_id' => $userId,
        'trip_id' => $data['trip_id'],
         'count_seats' => $seatsRequested,
        //'paidwy' => 'subscription', // سيتم تحديد الاشتراك لكل راكب لاحقًا
    ]);

    foreach ($data['passengers'] as $passenger) {
        // البحث عن اشتراك صالح للراكب حسب الوجهة
        $subscription = Subscription::where('user_id', $userId)
            ->where('rest_trips', '>=', 1)
            ->where('end_at', '>=', now())
            // ->where(function ($query) use ($passenger) {
            //     $query->whereJsonContains('cities', $passenger['to']);
            // })
            ->first();

        // إدراج الراكب
        Passenger::create([
            'reservation_id' => $reservation->id,
            'first_name' => $passenger['first_name'],
            'father_name' => $passenger['father_name'],
            'last_name' => $passenger['last_name'],
            'National_number' => $passenger['National_number'],
            'seat_number' => $passenger['seat_number'],
            'from' => $passenger['from'],
            'to' => $passenger['to'],
            'subscription_id' => $subscription?->id,
        ]);



        // خصم رحلة واحدة إن وجد الاشتراك
        if ($subscription) {
            $subscription->decrement('rest_trips');
        }
    }
$trip->decrement('available_seats', $seatsRequested);

    return response()->json([
        'message' => 'تم الحجز بنجاح مع التحقق من الاشتراكات',
        'reservation_id' => $reservation->id
    ], 201);


}
public function updatee(Request $request, $reservationId,$userId)
{
    // من التطبيق نفسه، يجي user_id من غير auth رسمي
   // $userId = $request->input('user_id');
   // $userId = $request->user_id;


    // if (!$userId) {
    //     return response()->json(['message' => 'يجب تمرير رقم المستخدم.'], 400);
    // }

    // $reservation = Reservation::where('id', $reservationId)
    //     ->where('user_id', $userId)
    //     ->first();

    // if (!$reservation) {
    //     return response()->json(['message' => 'الحجز غير موجود أو لا تملك صلاحية التعديل عليه.'], 404);
    // }

    // $data = $request->validate([
    //     'count_seats' => 'sometimes|integer|min:1',
    //     'passengers' => 'sometimes|array',
    //     'passengers.*.id' => 'required|exists:passengers,id',
    //     'passengers.*.first_name' => 'sometimes|string',
    //     'passengers.*.father_name' => 'sometimes|string',
    //     'passengers.*.last_name' => 'sometimes|string',
    //     'passengers.*.National_number' => 'sometimes|numeric|digits:11',
    //     'passengers.*.seat_number' => 'sometimes|integer',
    //     'passengers.*.from' => 'sometimes|string',
    //     'passengers.*.to' => 'sometimes|string',
    // ]);

    // if (isset($data['count_seats'])) {
    //     $reservation->update(['count_seats' => $data['count_seats']]);
    // }

    // if (isset($data['passengers'])) {
    //     foreach ($data['passengers'] as $passengerData) {
    //         Passenger::where('id', $passengerData['id'])
    //             ->where('reservation_id', $reservation->id)
    //             ->update($passengerData);
    //     }
    // }

    // return response()->json(['message' => 'تم التعديل بنجاح']);
$reservation = Reservation::where('id', $reservationId)
        ->where('user_id', $userId)
        ->first();

      $request->validate([
      //  'user_id' => 'nullable|exists:users,id',
        'trip_id' => 'required|exists:trips,id',
        'count_seats' => 'required|integer|min:1',
        'paidwy' => 'required|in:cach,subscription',
    ]);

    $reservation = Reservation::findOrFail($userId);

    $reservation->update([
      //  'user_id' => $request->user_id,
        'trip_id' => $request->trip_id,
        'count_seats' => $request->count_seats,
        'paidwy' => $request->paidwy,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'تم تحديث الحجز بنجاح',
        'reservation' => $reservation
    ]);
}
public function hastore(Request $request)
{
    $syrianGovernorates = [
        'دمشق', 'ريف دمشق', 'حلب', 'حمص', 'حماة', 'اللاذقية',
        'طرطوس', 'درعا', 'القنيطرة', 'السويداء', 'إدلب',
        'الرقة', 'دير الزور', 'الحسكة'
    ];

    $userId = $request->input('user_id');

    $data = $request->validate([
        'trip_id' => 'required|exists:trips,id',
        'passengers' => 'required|array|min:1',
        'passengers.*.first_name' => 'required|string',
        'passengers.*.father_name' => 'required|string',
        'passengers.*.last_name' => 'required|string',
        'passengers.*.National_number' => 'required|numeric|digits:11|unique:passengers,National_number',
        'passengers.*.seat_number' => 'required|integer',
        'passengers.*.from' => ['required', 'string', Rule::in($syrianGovernorates)],
        'passengers.*.to' => ['required', 'string', Rule::in($syrianGovernorates)],
    ]);

    $trip = Trip::with('bus')->findOrFail($data['trip_id']);
    $bus = $trip->bus;

    $seatsRequested = count($data['passengers']);

    // ✅ احسب عدد الكراسي المحجوزة مسبقًا
    $reservedSeats = Reservation::where('trip_id', $trip->id)->sum('count_seats');

    // ✅ الكراسي المتاحة = كل كراسي الباص - المحجوزة
    $availableSeats = $bus->seats_count - $reservedSeats;

    if ($availableSeats < $seatsRequested) {
        return response()->json([
            'message' => 'عدد المقاعد المتاحة غير كافٍ لهذه الرحلة.',
            'available_seats' => $availableSeats
        ], 400);
    }

    // ✅ إنشاء الحجز
    $reservation = Reservation::create([
        'user_id' => $userId,
        'trip_id' => $trip->id,
        'count_seats' => $seatsRequested,
        // 'paidwy' => 'subscription', // يتم تحديده لاحقًا
    ]);

    foreach ($data['passengers'] as $passenger) {
        $subscription = Subscription::where('user_id', $userId)
            ->where('rest_trips', '>=', 1)
            ->where('end_at', '>=', now())
            ->first();

        Passenger::create([
            'reservation_id' => $reservation->id,
            'first_name' => $passenger['first_name'],
            'father_name' => $passenger['father_name'],
            'last_name' => $passenger['last_name'],
            'National_number' => $passenger['National_number'],
            'seat_number' => $passenger['seat_number'],
            'from' => $passenger['from'],
            'to' => $passenger['to'],
            'subscription_id' => $subscription?->id,
        ]);

        if ($subscription) {
            $subscription->decrement('rest_trips');
        }
    }

    // return response()->json([
    //     'message' => 'تم الحجز بنجاح مع التحقق من الاشتراكات',
    //     'reservation_id' => $reservation->id
    // ], 201);
    return response()->json([
    'message' => 'تم الحجز بنجاح مع التحقق من الاشتراكات',
    'reservation_id' => $reservation->id,
    'seats_info' => [
        'total_seats' => $bus->seats_count,
        'reserved_seats' => $reservedSeats,
        'available_seats' => $availableSeats,
    ]
], 201);

}
}
