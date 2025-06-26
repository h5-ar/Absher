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

    return response()->json([
        'status' => true,
        'companies' => $companies,
    ]);
    }
public function show($id)
    {
        $company = Company::with(['trips.path', 'trips.reservations', 'trips.bus'])->findOrFail($id);

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
        ]);
    }

   
}
