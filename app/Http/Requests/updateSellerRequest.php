<?php

namespace App\Http\Requests;

use App\Enums\CompanySize;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class updateSellerRequest extends FormRequest
{

    protected function prepareForValidation(): void
    {
        if ($this->has('active') && $this->active == 'on') {
            $this->merge([
                'active' => true,
            ]);
        } else {
            $this->merge([
                'active' => false,
            ]);
        }

        if ($this->has('cash') && $this->cash == 'on') {
            $this->merge([
                'cash' => true,
            ]);
        } else {
            $this->merge([
                'cash' => false,
            ]);
        }
    }

    public function rules(): array
    {


        $rules = [
            'name'                  => ['nullable', 'string'],
            'last_name'             => ['nullable'],
            'email'                 => ['nullable', 'email', 'unique:users,email,' . request()->route('user_id'). ',id'],
            'username'              => ['nullable', 'unique:users,username,' . request()->route('user_id'). ',id'],
            'phone_number'          => ['nullable', 'unique:users,phone_number,' . request()->route('user_id'). ',id', 'starts_with:09'],
            'gender'                => ['nullable'],
            'birth_date'            => ['nullable', 'date', 'before:today'],
            'password'              => ['nullable', 'confirmed', 'min:8'],
            'company_name'          => ['nullable', 'string',],
            'password'              => ['nullable', 'confirmed', 'min:8'],
            'company_size'          => ['nullable', Rule::in(CompanySize::casesValue())],
            'address'               => ['nullable', 'string'],
            'city'                  => ['nullable', 'string'],
            'street'                => ['nullable', 'string'],
            'industry'              => ['nullable', 'string'],
            'description'           => ['nullable', 'string'],
            'join_code'             => ['nullable', 'string'],
            'comments'              => ['nullable', 'string'],
            'preference'            => ['nullable', Rule::in(['email', 'phone_number'])],
            'active'                => ['nullable', 'boolean'],
            'cash'                  => ['nullable', 'boolean'],
            'bank_name'             => ['nullable'],
            'account_number'        => [Rule::requiredIf(fn () => $this->bank_name), 'nullable', 'numeric', 'digits:15'],
            'long'                  => ['nullable', 'numeric', 'between:-90,90'],
            'lat'                   => ['nullable', 'numeric', 'between:-180,180'],
            'portfolio'             => ['nullable', 'file'],
            'supporting_document'   => ['nullable', 'file'],
            'marketing_plan'        => ['nullable', 'file'],
        ];
        return $rules;
    }


    public function messages(): array
    {
        return [
            'bank_name.required' => 'The bank name is required if the cash is inactive',
            'account_name.required' => 'The account number is required if the cash is inactive',
        ];
    }
}
