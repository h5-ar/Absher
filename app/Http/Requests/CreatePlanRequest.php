<?php

namespace App\Http\Requests;

use App\Enums\Governorates;
use App\Enums\BusType;

use App\Enums\Available;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreatePlanRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            'name' => ['required', 'string', 'max:50'],
            'TypeBusOfPlan'  => ['required', 'string', Rule::enum(BusType::class)],
            'trips_number'  => ['required', 'integer', 'min:3'],
            'available' => ['required', 'string', Rule::enum(Available::class)],
            'price' => ['required', 'numeric'],
            'from' => ['required', Rule::enum(Governorates::class)],
            'to' => ['required', Rule::enum(Governorates::class), 'different:from']
        ];
    }
}
