<?php

namespace App\Http\Requests;

use App\Enums\BusType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateTripVehicleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
        
            'price'=> ['required'],
            'Bus'=> ['required'],
            'datetime'=> ['required'],
            'day'=>['required'],
            'from'=>['required'],
            'to1'=>['required'],
            'to2'=>['required'],
            'to3'=>['nullable'],
            'to4'=>['nullable'],
            'to5'=>['nullable']
            
        ];
    }
}
