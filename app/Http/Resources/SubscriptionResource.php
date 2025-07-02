<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class SubscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {


        return [
            // المعلومات الأساسية
            'subscription_id' => $this->id,
            'status' => $this->status,

            // معلومات الشركة (المبسطة)
            'company' =>
                $this->when($this->company, function() {
    return [
                'id' => $this->company->id,
                'name' => $this->company->name,
                'logo' => $this->company->logo_url, // ستحتاج لتعريف هذا في نموذج Company
    ];
            }),

            // تفاصيل الخطة
            'plan' => [
                'plan_id' => $this->plan->id,
                'name' => $this->plan->name,
                'price' => $this->plan->price,
                'duration' => $this->plan->duration_days,
                'total_trips' => $this->plan->trip_limit,
            ],

            // تواريخ الاشتراك
           // 'start_at' => $this->start_date->format('Y-m-d'),
            //'end_at' => $this->end_date->format('Y-m-d'),
            'start_date' => $this->start_at ? $this->start_at->format('Y-m-d') : null,
'end_date'   => $this->end_at ? $this->end_at->format('Y-m-d') : null,


            // إحصائيات الاستخدام
            'remaining_trips' => $this->remaining_trips,
            'used_trips' => $this->plan->trip_limit - $this->remaining_trips,

            // حقول محسوبة
            'is_active' => $this->calculateIsActive(),
            'days_remaining' => Carbon::parse($this->end_date)->diffInDays(Carbon::now()),




            // التواريخ التقنية
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * حساب إذا كان الاشتراك نشطاً
     */
    protected function calculateIsActive(): bool
    {
        return $this->status === 'active' &&
               Carbon::parse($this->end_date)->greaterThanOrEqualTo(Carbon::now());
    }




}
