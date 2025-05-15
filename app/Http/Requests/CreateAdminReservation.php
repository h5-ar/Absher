<?php

namespace App\Http\Requests;

use App\Models\Passenger;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;

class CreateAdminReservation extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'trip_id' => ['required', 'exists:trips,id'],
            'seats_count' => ['required', 'integer', 'min:1'],
            'passengers' => ['required', 'array'],
            'passengers.*.first_name' => ['required', 'string'],
            'passengers.*.father_name' => ['required', 'string'],
            'passengers.*.last_name' => ['required', 'string'],
            'passengers.*.subscribtion_id' => ['integer', 'exists:subscribtions,id', 'nullable'],
            'passengers.*.seat_number' => [
                'required',
                'integer',
            ]
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     */
    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $tripId = $this->input('trip_id');
            $passengers = $this->input('passengers');

            foreach ($passengers as $index => $passenger) {
                $seatNumber = $passenger['seat_number'];
                $exists = Passenger::whereHas('reservation', function ($q) use ($tripId) {
                    $q->where('trip_id', $tripId);
                })
                    ->where('seat_number', $seatNumber)
                    ->exists();

                if ($exists) {
                    $validator->errors()->add("passengers.$index.seat_number", "المقعد {$seatNumber} محجوز مسبقاً");
                }
            }
        });
    }
}
