<?php

namespace App\Http\Requests;

use App\Enums\BusType;
use App\Enums\Available;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePlanRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'select2-type-container'  => ['required', 'string', Rule::enum(BusType::class)],
            'trips_number'  => ['required', 'integer', 'min:3'],
            'available' => ['required', 'string', Rule::enum(Available::class)],
            'price' => ['required', 'integer']
        ];
    }
}
