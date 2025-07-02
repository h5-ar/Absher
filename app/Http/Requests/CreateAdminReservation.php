<?php

namespace App\Http\Requests;

use App\Models\Passenger;
use App\Models\Trip;
use App\Models\Reservation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class CreateAdminReservation extends FormRequest
{
    public function rules(): array
    {
        return [
            'trip_id' => 'required|exists:trips,id',
            'seats_count' => [
                'required',
                'integer',
                'min:1',
            ],
            'passengers' => 'required|array',
            'passengers.*.first_name' => 'required|string',
            'passengers.*.father_name' => 'required|string',
            'passengers.*.last_name' => 'required|string',
            'passengers.*.departure_point' => 'required|different:passengers.*.arrival_point',
            'passengers.*.arrival_point' => 'required|different:passengers.*.departure_point',

            'passengers.*.seat_number' => 'required|string',

            'passengers.*.id' => 'nullable|exists:passengers,id'
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $tripId = $this->input('trip_id');
            $passengers = $this->input('passengers');

            $trip = Trip::with('bus')->find($tripId);
            $reservedSeats = Reservation::where('trip_id', $tripId)
                ->sum('count_seats');

            $availableSeats = $trip->bus->seats_count - $reservedSeats;
            if ($this->input('seats_count') > $availableSeats) {
                $validator->errors()->add(
                    "seats_count",
                    "لا يوجد مقاعد كافية. المقاعد المتاحة: {$availableSeats}"
                );
            }

            foreach ($passengers as $index => $passenger) {
                $seatNumber = $passenger['seat_number'];
                $passengerId = $passenger['id'] ?? null;

                $query = Passenger::whereHas('reservation', function ($q) use ($tripId) {
                    $q->where('trip_id', $tripId);
                })->where('seat_number', $seatNumber);

                // إذا كان تعديلاً وليس إضافة جديدة
                if ($passengerId) {
                    $query->where('id', '!=', $passengerId);
                }

                if ($query->exists()) {
                    $validator->errors()->add(
                        "passengers.$index.seat_number",
                        "المقعد {$seatNumber} محجوز مسبقاً"
                    );
                }
            }
        });
    }
}
