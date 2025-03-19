<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\Governorates;
use App\Enums\Days;
use Carbon\Carbon;
use Illuminate\Validation\Validator;
use App\Models\Trip;

class CreateTripQuickRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'price' => ['required', 'numeric'],
            'Bus' => ['required', 'exists:buses,id'],
            'datetime' => ['required', 'date'],
            'day' => ['required', Rule::enum(Days::class)],
            'from' => ['required', Rule::enum(Governorates::class)],
            'to' => ['required', Rule::enum(Governorates::class), 'different:from']
        ];
    }
    public function withValidator($validator)
    {
        $this->ValidatorDate($validator);
        $this->ValidatorBus($validator);
    }
    public function ValidatorDate($validator)
    {
        $validator->after(function (Validator $validator) {
            $selectedDate = Carbon::parse($this->input('datetime'));
            $expectedDay = $selectedDate->format('l');

            if ($this->input('day') !== $expectedDay) {
                $validator->errors()->add('day', 'اليوم المدخل لا يتطابق مع التاريخ المختار.');
            }
        });
    }




    public function ValidatorBus($validator)
    {
        $validator->after(function (Validator $validator) {
            $exists = Trip::where('bus_id', $this->input('Bus'))
                ->where('take_off_at', $this->input('datetime'))
                ->exists();

            if ($exists) {
                $validator->errors()->add('Bus', 'هذا الباص لديه رحلة بالفعل في نفس اليوم.');
            }
        });
    }
}
