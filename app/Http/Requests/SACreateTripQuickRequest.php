<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\Governorates;
use App\Enums\Days;
use Carbon\Carbon;
use Illuminate\Validation\Validator;
use App\Models\Trip;
use App\Models\Bus;


class SACreateTripQuickRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'company' => ['required'],
            'price' => ['required', 'numeric', 'min:0'],
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
            if ($selectedDate->isPast() && !$selectedDate->isToday()) {
                $validator->errors()->add('datetime', 'لا يمكن إنشاء رحلة في تاريخ مضى.');
            }
        });
    }




    public function ValidatorBus($validator)
    {
        $validator->after(function (Validator $validator) {
            $bus = Bus::where('id', $this->Bus)
                ->where('Company_id', $this->company)
                ->first();

            if (!$bus) {
                $validator->errors()->add('Bus', 'هذا الباص غير تابع للشركة المحددة.');
                return;
            }
            $exists = Trip::where('bus_id', $this->input('Bus'))
                ->where('take_off_at', $this->input('datetime'))
                ->exists();

            if ($exists) {
                $validator->errors()->add('Bus', 'هذا الباص لديه رحلة بالفعل في نفس اليوم.');
            }
        });
    }
}
