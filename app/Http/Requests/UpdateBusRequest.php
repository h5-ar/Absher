<?php

namespace App\Http\Requests;

use App\Enums\BusType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBusRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type'  => ['required', 'string', Rule::enum(BusType::class)],
            'seats_count'  => ['required', 'integer', 'min:20', 'max:80']
        ];
    }
}
