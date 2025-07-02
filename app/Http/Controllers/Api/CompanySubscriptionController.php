<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubscriptionResource;
use App\Models\Company;
use App\Models\Plan;
use Carbon\Carbon;
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
          'company_id'=>'required|exists:companies,id',
        'plan_id' => 'required|exists:plans,id',
        'user_id' => 'required|exists:users,id',
    ]);

    $userId = $request->user_id;


    $plan = Plan::find($request->plan_id);

    if (!$plan) {
        return response()->json([
            'success' => false,
            'message' => 'الخطة غير موجودة.',
        ], 404);
    }


    $subscription = Subscription::create([
        'user_id' => $userId,

        'plan_id' => $plan->id,
        'rest_trips' => $plan->trips_number,
        'start_at' => now(),
        'end_at' => now()->addDays($plan->duration_days ?? 30), // إذا duration_days موجودة في plans
    ]);

    return response()->json([
        'success' => true,
        'message' => 'تم إنشاء الاشتراك بنجاح',
        'data' => $subscription,
    ], 201);

}

public function renew(Request $request, $subscriptionId,$userId): JsonResponse
{


  $oldSubscription = Subscription::with('plan')->findOrFail($subscriptionId);
$endAt = $oldSubscription->end_at ? Carbon::parse($oldSubscription->end_at) : null;

   // تحقق إذا كان الاشتراك لا يزال فعالًا
    if ($oldSubscription->end_at && $oldSubscription->end_at->isFuture()) {
        return response()->json([
            'success' => false,
            'message' => 'لا يمكن تجديد الاشتراك لأنه لا يزال فعالًا.',
        ], 400);
    }
    $newSubscription = Subscription::create([
        'user_id'     => $oldSubscription->user_id,
        'plan_id'     => $oldSubscription->plan_id,
        'rest_trips'  => $oldSubscription->plan->trips_number,
        'start_at'    => now(),
         'end_at'      => now()->addDays($oldSubscription->plan->duration_days),
    ]);

    return response()->json([
        'success' => true,
        'message' => 'تم إنشاء اشتراك جديد بنجاح كجزء من عملية التجديد',
       'data' => new SubscriptionResource($newSubscription->load(['plan', 'plan.company']))
    ]);
}
public function cancel(Request $request, $subscriptionId,$userId): JsonResponse
{

    $subscription = Subscription::findOrFail($subscriptionId);

    $createdAt = Carbon::parse($subscription->created_at);
    if ($createdAt->diffInHours(now()) > 24) {
        return response()->json([
            'success' => false,
            'message' => 'لا يمكن حذف الاشتراك بعد مرور 24 ساعة من تفعيله.'
        ], 403);
    }

    $subscription->delete();

    return response()->json([
        'success' => true,
        'message' => 'تم حذف الاشتراك بنجاح.'
    ]);

}
public function userSubscriptions(Request $request,$userId ){

    $subscriptions = Subscription::with('plan')
    ->where('user_id', $userId)
    ->get()
    ->map(function ($subscription) {
//           $plan = $subscription->plan;
//    $path = $plan->path;

//         $from = $path?->from ?? 'غير محدد';
//         $toDestinations = collect([
//             $path?->to1,
//             $path?->to2,
//             $path?->to3,
//             $path?->to4,
//             $path?->to5,
//         ])->filter()->values()->all();

        $bus = \App\Models\Bus::where('type', $subscription->plan->type_bus)->first();

        return [
            'id' => $subscription->id,
            //'plan_name' => $subscription->plan->name,

           // 'price' => $subscription->plan->price,
            'rest_trips' => $subscription->rest_trips,
            'start_at' => $subscription->start_at,
            'end_at' => $subscription->end_at,
            'plans' => $bus ? [
                'id' => $bus->id,
                'type_bus' => $bus->type,
                 'name' => $subscription->plan->name,
            'total_price' => $subscription->plan->price,
           // 'from' => $from,
            //'to' => $toDestinations,

            ] : null,
        ];
    });

return response()->json([
    'success' => true,
    'subscriptions' => $subscriptions,
]);

   // $userId = $request->input('user_id');


    // $subscriptions = Subscription::with('plan')صح
    //     ->where('user_id', $userId)
    //     ->get()
    //     ->map(function ($subscription) {

    //         return [
    //             'id' => $subscription->id,
    //             'plan_name' => $subscription->plan->name,
    //             'type_bus' => $subscription->plan->type_bus,
    //             'price' => $subscription->plan->price,
    //             'rest_trips' => $subscription->rest_trips,
    //             'start_at' => $subscription->start_at,
    //             'end_at' => $subscription->end_at,
    //         ];
    //     });

    // return response()->json([
    //     'success' => true,
    //     'subscriptions' => $subscriptions,
    // ]);
}

}
