<?php

namespace App\Http\Controllers;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanysController extends Controller
{
    //

public function getCompaniesApi()
    {
    $companies = Company::select('id', 'name', 'image')->get();
     $companies->transform(function ($company) {
        $company->image = $company->image
            ? url('uploads/companies/' . $company->image)
            : null;
        return $company;
    });

    return response()->json([
        'status' => true,
        'companies' => $companies,
    ]);
    }
public function show($id)//حذف
    {
        $company = Company::with(['trips.path', 'trips.reservations', 'trips.bus','plans'])->findOrFail($id);

        $trips = $company->trips->map(function($trip) {
            $path = $trip->path;


            $toDestinations = [];
            if ($path) {
                $toDestinations = collect([
                    $path->to1,
                    $path->to2,
                    $path->to3,
                    $path->to4,
                    $path->to5,
                ])->filter()->values()->all();
            }

            $reservedSeats = $trip->reservations->sum('count_seats');
            $totalSeats = $trip->bus->seats_count ?? 0; // عدد المقاعد في الباص
            $availableSeats = $totalSeats - $reservedSeats;


            return [
                'id' => $trip->id,
                'price' => $trip->price,
                'take_off_at' => $trip->take_off_at,
                'path_type' => $path->type ?? 'unknown',
                'from' => $path->from ?? 'غير معروف',
                'to' => $toDestinations,
                'reserved_seats' => $reservedSeats,
                'available_seats' => $availableSeats,
                'bus_type' => $trip->bus->type,

            ];
        });
       $plans = $company->plans->map(function($plan) {
        return [
            'id' => $plan->id,
            'name' => $plan->name,
            'trips_number' => $plan->trips_number,
            'type_bus' => $plan->type_bus,
            'available' => $plan->available,
            'price' => $plan->price,
            'created_at' => $plan->created_at,
        ];
    });

        return response()->json([
            'status' => true,
            'company' => [
                'id' => $company->id,
                'name' => $company->name,
                'phone' => $company->phone,
                'email' => $company->email,
                'description' => $company->description,
            ],
            'trips' => $trips,
           'plans' => $plans,


        ]);
    }
//     public function getCompanyById($id)
// {
//     // جلب الشركة حسب الـ ID مع الرحلات، المسار، والباصات
//     $company = Company::with([
//         'trips.path', // المسار
//         'trips.bus', // الباص
//         'trips.reservations.passengers',
//         'plans',
//          // الركاب
//     ])->findOrFail($id); // جلب الشركة بناءً على ID

//     // تعديل البيانات لكل رحلة ضمن الشركة
//     $company->trips = $company->trips->map(function($trip) {
//         // استخراج معلومات المسار
//         $path = $trip->path;
//         $toDestinations = collect([
//             $path->to1??null,
//             $path->to2??null,
//             $path->to3??null,
//             $path->to4??null,
//             $path->to5??null,
//         ])->filter()->values()->all();
//          $tripType = count($toDestinations) > 1 ? 'متقطعة' : 'سريعة';

//         // معلومات الباص
//         $bus = $trip->bus;
//         $busData = [
//             'id' => $bus->id,
//             'type' => $bus->type,
//             'seats_count' => $bus->seats_count ?? 0, // عدد المقاعد
//             'reserved_seat_numbers' => $trip->reservations->flatMap(function($reservation) {
//                 // جمع أرقام المقاعد المحجوزة من الركاب
//                 return $reservation->passengers->pluck('seat_number');
//             })->unique()->values(), // أرقام المقاعد المحجوزة
//         ];

//         return [
//             'id' => $trip->id,
//             'price' => $trip->price,
//             'take_off_at' => $trip->take_off_at,
//             'path' => [
//                 'type' => $path->type ?? 'غير معروف', // نوع المسار
//                 'from' => $path->from ?? 'غير معروف', // من
//                 'to' => $toDestinations, // إلى (المصفوفة اللي فيها الوجهات)
//             ],
//             'bus' => $busData, // تفاصيل الباص مع أرقام المقاعد المحجوزة
//         ];
//     });
//      $plans = $company->plans->map(function($plan) {
//         return [
//             'id' => $plan->id,
//             'name' => $plan->name,
//             'trips_number' => $plan->trips_number,
//             'type_bus' => $plan->type_bus,
//             'available' => $plan->available,
//             'price' => $plan->price,
//             'form' => $plan->form,
//             'to' => $plan->to,

//             'created_at' => $plan->created_at,

//         ];
//     });

//     return response()->json([
//         'status' => true,
//         'company' => [
//             'id' => $company->id,
//             'name' => $company->name,
//             'phone' => $company->phone,
//             'email' => $company->email,
//             'description' => $company->description,
//         ],
//         'trips' => $company->trips,
//            'plans' => $plans,

//     ]);
// }
public function getCompanyById($id)
{
    $company = Company::with([
        'trips.path',
        'trips.bus',
        'trips.reservations.passengers',
        'plans',
    ])->findOrFail($id);

    // تعديل بيانات الرحلات
    $company->trips = $company->trips->map(function($trip) {
        $path = $trip->path;

        $toDestinations = collect([
            $path->to1 ?? null,
            $path->to2 ?? null,
            $path->to3 ?? null,
            $path->to4 ?? null,
            $path->to5 ?? null,
        ])->filter()->values()->all();

        $tripType = count($toDestinations) > 1 ? 'متقطعة' : 'سريعة';

        $bus = $trip->bus;
        $busData = [
            'id' => $bus->id,
            'type' => $bus->type,
            'seats_count' => $bus->seats_count ?? 0,
            'reserved_seat_numbers' => $trip->reservations->flatMap(function($reservation) {
                return $reservation->passengers->pluck('seat_number');
            })->unique()->values(),
        ];

        return [
            'id' => $trip->id,
            'price' => $trip->price,
            'take_off_at' => $trip->take_off_at,
            'trip_type' => $tripType, // ✅ نوع الرحلة
            'path' => [
                //'type' => $path->type ?? 'غير معروف',
                'from' => $path->from ?? 'غير معروف',
                'to' => $toDestinations,
            ],
            'bus' => $busData,
        ];
    });

    // تعديل بيانات الخطط
    $plans = $company->plans->map(function($plan) {
        return [
            'id' => $plan->id,
            'name' => $plan->name,
            'trips_number' => $plan->trips_number,
            'type_bus' => $plan->type_bus,
            'available' => $plan->available,
            'price' => $plan->price,
            'form' => $plan->form,
            'to' => $plan->to,
            'created_at' => $plan->created_at,
        ];
    });

    return response()->json([
        'status' => true,
        'company' => [
            'id' => $company->id,
            'name' => $company->name,
            'phone' => $company->phone,
            'email' => $company->email,
            'description' => $company->description,
        ],
        'trips' => $company->trips,
        'plans' => $plans,
    ]);
}

public function hagetCompanyById($id)
{
    $company = Company::with([
        'trips.path',
        'trips.bus',
        'trips.reservations.passengers',
        'plans',
    ])->findOrFail($id);

    // تعديل بيانات الرحلات
    $company->trips = $company->trips->map(function($trip) {
        $path = $trip->path;

        $toDestinations = collect([
            $path->to1 ?? null,
            $path->to2 ?? null,
            $path->to3 ?? null,
            $path->to4 ?? null,
            $path->to5 ?? null,
        ])->filter()->values()->all();

        $tripType = count($toDestinations) > 1 ? 'متقطعة' : 'سريعة';

        $bus = $trip->bus;

        // أرقام الكراسي المحجوزة
        $reservedSeatNumbers = $trip->reservations->flatMap(function($reservation) {
            return $reservation->passengers->pluck('seat_number');
        })->unique()->values();

        // حسابات الكراسي
        $totalSeats = $bus->seats_count ?? 0;
        $reservedSeats = $reservedSeatNumbers->count();
        $availableSeats = $totalSeats - $reservedSeats;

        $busData = [
            'id' => $bus->id,
            'type' => $bus->type,
            'seats_count' => $totalSeats,
            'reserved_seat_numbers' => $reservedSeatNumbers,
            'reserved_seats' => $reservedSeats,
            'available_seats' => $availableSeats,
        ];

        return [
            'id' => $trip->id,
            'price' => $trip->price,
            'take_off_at' => $trip->take_off_at,
            'trip_type' => $tripType,
            'path' => [
                'from' => $path->from ?? 'غير معروف',
                'to' => $toDestinations,
            ],
            'bus' => $busData,
        ];
    });
    

    // تعديل بيانات الخطط
    $plans = $company->plans->map(function($plan) {
        return [
            'id' => $plan->id,
            'name' => $plan->name,
            'trips_number' => $plan->trips_number,
            'type_bus' => $plan->type_bus,
            'available' => $plan->available,
            'price' => $plan->price,
            'form' => $plan->form,
            'to' => $plan->to,
            'created_at' => $plan->created_at,
        ];
    });

    return response()->json([
        'status' => true,
        'company' => [
            'id' => $company->id,
            'name' => $company->name,
            'phone' => $company->phone,
            'email' => $company->email,
            'description' => $company->description,
        ],
        'trips' => $company->trips,
        'plans' => $plans,
    ]);
}


 }
