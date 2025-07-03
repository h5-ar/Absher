<?php

namespace App\Http\Requests;

use App\Models\Passenger;
use App\Models\Trip;
use App\Models\Reservation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class CreatePassengerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'reservation_id' => 'required|exists:reservations,id', // تأكد من وجود الحجز
            'National_number' => 'required',
            'first_name' => 'required|string',
            'father_name' => 'required|string',
            'last_name' => 'required|string',
            'departure_point' => 'required|different:passengers.*.arrival_point',
            'arrival_point' => 'required|different:passengers.*.departure_point',
            'seat_number' => 'required|string',
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $reservationId = $this->input('reservation_id');
            $reservation = Reservation::with('trip')->find($reservationId);
            $tripId = $reservation->trip_id;
            $passengerId = $this->input('passenger_id');
            $seatNumber = $this->input('seat_number');

            $query = Passenger::whereHas('reservation', function ($q) use ($tripId) {
                $q->where('trip_id', $tripId);
            })
                ->where('seat_number', $seatNumber)->where('id', '!=', $passengerId);

            if ($query->exists()) {
                $validator->errors()->add(
                    "seat_number",
                    "المقعد {$seatNumber} محجوز مسبقاً"
                );
            }
        });
    }
}
