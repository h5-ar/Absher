<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class CreateSubscription extends FormRequest
{
    public function rules(): array
    {
        return [
            'booking_source' => 'required|in:wep,app', // حقل المصدر
            'user_id' => [
                'required_if:source,mobile', // مطلوب إذا المصدر موبايل
                'nullable', // يسمح بقيم null
                // يمكن إضافة قيود أخرى هنا
            ],
        ];
    }
}
