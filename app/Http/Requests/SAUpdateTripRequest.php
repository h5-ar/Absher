<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\Governorates;
use App\Enums\Days;


class SAUpdateTripRequest extends FormRequest
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

            'price' => ['required', 'numeric'],
            'Bus' => ['required'],
            'datetime' => ['required', 'date'],
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
