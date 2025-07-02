<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\Governorates;
use App\Enums\Days;


class UpdateTripRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'price' => ['required', 'numeric', 'min:0'],
            'Bus' => ['required'],
            'datetime' => ['required'],
            'day' => ['required', Rule::enum(Days::class)],
            'from' => ['required', Rule::enum(Governorates::class)],
            'to1' => ['required', Rule::enum(Governorates::class)],
            'to2' => ['nullable', Rule::enum(Governorates::class)],
            'to3' => ['nullable', Rule::enum(Governorates::class)],
            'to4' => ['nullable', Rule::enum(Governorates::class)],
            'to5' => ['nullable', Rule::enum(Governorates::class)]
        ];
    }
}
