<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class VarianceRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [];
        if (Route::is('dashboard.variances.store')) {
            $rules = [
                'name'      => ['required', 'string', 'unique:variances,name'],
                'name_ar'   => ['required', 'string'],
            ];
        } elseif (Route::is('dashboard.variances.update')) {
            $rules = [
                'name'              => ['nullable', 'string', 'unique:variances,name,' . request()->route('id') . ',id'],
                'name_ar'           => ['nullable', 'string'],
                'values'            => ['required', 'array'],
                'values.*.id'       => ['nullable', 'string'],
                'values.*.value'    => ['required', Rule::when($this->name == 'color', ['hex_color'], ['string'])]
            ];
        }

        return $rules;
    }

    public function passedValidation()
    {
        if ($this->name == 'color') {
            $values = $this->values;
            foreach ($values as $key => $value) {
                $values[$key]['value'] = str_replace('#', '', $value['value']);
            }
            $this->replace(['values' => $values]);
        }

        if (count($this->values) != count(array_unique(collect($this->values)
            ->map(
                function ($value) {
                    return $value['value'];
                }
            )
            ->flatten()
            ->toArray()))) {
            $this->validator->errors()->add('values.*.value', translate('Values Should be Unique'));
            throw new ValidationException($this->validator);
        }
    }
}
