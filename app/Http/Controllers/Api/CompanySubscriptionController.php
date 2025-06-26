<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubscriptionResource;
use App\Models\Company;
use App\Models\Plan;
use App\Models\Carbon;
use App\Models\Subscription;
use Illuminate\Http\JsonResponse;

class CompanySubscriptionController extends Controller
{
    public function getCompanySubscriptions(Request $request, $companyId): JsonResponse
    {
        $request->validate([
            'status' => 'sometimes|in:active,expired,canceled',
            'sort' => 'sometimes|in:start_date,end_date,created_at',
            'order' => 'sometimes|in:asc,desc'
        ]);

        $query = Subscription::with(['plan', 'company'])
            ->whereRelation('plan','company_id', $companyId);

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $sort = $request->input('sort', 'end_date');
        $order = $request->input('order', 'desc');
        $query->orderBy($sort, $order);

        $subscriptions = $query->paginate($request->input('per_page', 15));

        return response()->json([
            'success' => true,
            'message' => 'تم جلب الاشتراكات بنجاح',
            'data' => SubscriptionResource::collection($subscriptions),
            'pagination' => [
                'total' => $subscriptions->total(),
                'per_page' => $subscriptions->perPage(),
                'current_page' => $subscriptions->currentPage(),
                'last_page' => $subscriptions->lastPage(),
            ]
        ]);
    }


    //حذف
    public function getSubscriptionDetails($companyId, $subscriptionId): JsonResponse
    {
        $subscription = Subscription::with(['plan', 'company'])
            ->whereRelation('plan','company_id', $companyId)
            ->findOrFail($subscriptionId);

        return response()->json([
            'success' => true,
            'message' => 'تم جلب تفاصيل الاشتراك بنجاح',
            'data' => new SubscriptionResource($subscription)
        ]);
    }

    //حذف
    public function getActiveSubscription($companyId): JsonResponse
    {
        $subscription = Subscription::with(['plan', 'company'])
            ->whereRelation('plan','company_id', $companyId)
            ->where('status', 'active')
            ->where('end_at', '>=', now()->toDateString())
            ->first();

        if (!$subscription) {
            return response()->json([
                'success' => false,
                'message' => 'لا يوجد اشتراك نشط للشركة'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'تم جلب الاشتراك النشط بنجاح',
            'data' => new SubscriptionResource($subscription)
        ]);
    }




    public function updateRemainingTrips(Request $request, $companyId, $subscriptionId): JsonResponse
    {
        $request->validate([
            'rest_trips' => 'required|integer|min:0'
        ]);

        $subscription = Subscription::where('company_id', $companyId)
            ->findOrFail($subscriptionId);

        $subscription->update([
            'rest_trips' => $request->rest_trips
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث عدد الرحلات المتبقية',
            'data' => new SubscriptionResource($subscription->fresh(['plan', 'company']))
        ]);
    }

public function store(Request $request): JsonResponse
{
    $request->validate([
        'company_id' => 'required|exists:companies,id',
        'plan_id' => 'required|exists:plans,id',
        'user_id' => 'required|exists:users,id',

    ]);

    $plan = Plan::findOrFail($request->plan_id);

    $subscription = Subscription::create([
        'company_id' => $request->company_id,
        'user_id' => $request->user_id,
        'plan_id' => $plan->id,
        'rest_trips' => $plan->trip_limit,
        'start_at' => Carbon::now(),
        'end_at' => Carbon::now()->addDays($plan->duration_days),
        'status' => 'active',

    ]);

    return response()->json([
        'success' => true,
        'message' => 'تم إنشاء الاشتراك بنجاح',
        'data' => new SubscriptionResource($subscription)
    ], 201);
}

public function renew(Request $request, $subscriptionId): JsonResponse
{$subscription = Subscription::findOrFail($subscriptionId);

    $subscription->update([
        'end_at' => Carbon::parse($subscription->end_at)->addDays($subscription->plan->duration_days),
        'rest_trips' => $subscription->plan->trip_limit,
        'status' => 'active',

    ]);

    return response()->json([
        'success' => true,
        'message' => 'تم تجديد الاشتراك بنجاح',
        'data' => new SubscriptionResource($subscription->fresh(['plan', 'company']))
    ]);
}

public function cancel(Request $request, $subscriptionId): JsonResponse
{

    $subscription = Subscription::findOrFail($subscriptionId);

    $subscription->update([
        'status' => 'canceled',

        'canceled_at' => Carbon::now()
    ]);

    return response()->json([
        'success' => true,
        'message' => 'تم إلغاء الاشتراك بنجاح',
        'data' => new SubscriptionResource($subscription)
    ]);

}
}
