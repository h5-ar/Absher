<?php

namespace App\Http\Controllers\Api;


//use Carbon\Carbon;
use App\Models\Trip;
use App\Models\Shipping;
use App\Models\ItemShipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;


class ShippingsController extends Controller
{
    //
//
public function store(Request $request,$userId)
{
   // $userId =$userId;

    $request->validate([
     //   'user_id' => 'required|exists:users,id',
        'trip_id' => 'required|exists:trips,id',
        'name_user_to' => 'required|string',
        'phone_to' => 'required|string',
        'national_number_to' => 'required|string',
        'items' => 'required|array|min:1',
        'items.*.description_item' => 'required|string',
        'items.*.material_value' => 'required|string',
        'items.*.size' => 'required|in:صغير,متوسط,كبير',
    ]);



    $shipping = Shipping::create([
        'user_id' => $userId,
        'trip_id' => $request->trip_id,
        'name_user_to' => $request->name_user_to,
        'phone_to' => $request->phone_to,
        'national_number_to' => $request->national_number_to,
    ]);

    foreach ($request->items as $item) {
        $shipping->items()->create($item);
    }

    return response()->json([
        'message' => 'تم إنشاء الشحنة بنجاح',
      //  'shipping_id' => $shipping->id,
    ], 201);
}
   public function index($id)
{

    $shippings = Shipping::with('trip.path')
        ->where('user_id', $id)
      //  ->where('id', $shippingId)
        ->get()
        ->map(function ($shipping) {
            $path = optional(optional($shipping->trip)->path);

            // استخراج آخر وجهة فعلية غير فارغة من to1 → to5
            $lastDestination = collect([
                $path->to1,
                $path->to2,
                $path->to3,
                $path->to4,
                $path->to5
            ])->filter()->last() ?? 'غير معروف';

            return [
                'shipping_id' => $shipping->id,
                'from' => $path->from ?? 'غير معروف',
                'to' => $lastDestination,
                'status' => $shipping->shipment_status,
            ];
        });

    return response()->json($shippings);
}


   // عرض تفاصيل شحنة واحدة
  public function show(Request $request,$shipId, $userId)
{
    // $userId = $request->user_id;
    // $request->validate([
    //     'user_id' => 'required|exists:users,id',
    // ]);

    $shipping = Shipping::with(['items', 'trip.path'])
        ->where('id', $shipId)

        ->where('user_id', $userId)
        ->firstOrFail();

    $path = optional(optional($shipping->trip)->path);

    // استخراج آخر وجهة فعلية
    $lastDestination = collect([
        $path->to1, $path->to2, $path->to3, $path->to4, $path->to5
    ])->filter()->last() ?? 'غير معروف';

    return response()->json([
        'shipping_id' => $shipping->id,
        'name_user_to' => $shipping->name_user_to,
        'phone_to' => $shipping->phone_to,
        'national_number_to' => $shipping->national_number_to,
        'shipment_status' => $shipping->shipment_status,
        'trip_date' => $shipping->trip->date ?? 'غير معروف',
        'from' => $path->from ?? 'غير معروف',
        'to' => $lastDestination,
        'items' => optional($shipping->items)->map(function ($item) {
            return [
                'description_item' => $item->description_item,
                'material_value' => $item->material_value,
                'size' => $item->size,
            ];
        }),
    ]);
}


    // تحديث شحنة
//     public function update(Request $request, $id)
// {
//     $request->validate([
//         'name_user_to' => 'required|string',
//         'phone_to' => 'required|string',
//         'national_number_to' => 'required|string',
//         'items' => 'required|array|min:1',
//         'items.*.id' => 'required|exists:item_shipping,id',
//         'items.*.description_item' => 'required|string',
//         'items.*.material_value' => 'required|string',
//         'items.*.size' => 'required|in:صغير,متوسط,كبير',
//     ]);

//     $shipping = Shipping::with('items')->findOrFail($id);

//     // تحديث بيانات المستلم
//     $shipping->update([
//         'name_user_to' => $request->name_user_to,
//         'phone_to' => $request->phone_to,
//         'national_number_to' => $request->national_number_to,
//     ]);

//     // تحديث العناصر
//     foreach ($request->items as $itemData) {
//         $item = $shipping->items()->where('id', $itemData['id'])->first();
//         if ($item) {
//             $item->update([
//                 'description_item' => $itemData['description_item'],
//                 'material_value' => $itemData['material_value'],
//                 'size' => $itemData['size'],
//             ]);
//         }
//     }

//     return response()->json(['message' => 'تم تعديل الشحنة والعناصر بنجاح']);
// }
public function update(Request $request, $id)
{
    $request->validate([
        'name_user_to' => 'required|string',
        'phone_to' => 'required|string',
        'national_number_to' => 'required|string',
        'items' => 'required|array|min:1',
        'items.*.id' => 'required|exists:item_shipping,id',
        'items.*.description_item' => 'required|string',
        'items.*.material_value' => 'required|string',
        'items.*.size' => 'required|in:صغير,متوسط,كبير',
    ]);

    $shipping = Shipping::with('items')->findOrFail($id);

    // ✅ منع التعديل إذا كانت الحالة ليست "قيد المراجعة"
    if ($shipping->shipment_status !== 'قيد المراجعة') {
        return response()->json([
            'message' => 'لا يمكن تعديل الشحنة، لأنها تم شحنها أو توصيلها أو لم تعد قيد المراجعة.'
        ], 403);
    }

    // ✅ تحديث بيانات المستلم
    $shipping->update([
        'name_user_to' => $request->name_user_to,
        'phone_to' => $request->phone_to,
        'national_number_to' => $request->national_number_to,
    ]);

    // ✅ تحديث العناصر
    foreach ($request->items as $itemData) {
        $item = $shipping->items()->where('id', $itemData['id'])->first();
        if ($item) {
            $item->update([
                'description_item' => $itemData['description_item'],
                'material_value' => $itemData['material_value'],
                'size' => $itemData['size'],
            ]);
        }
    }

    return response()->json(['message' => 'تم تعديل الشحنة والعناصر بنجاح']);
}
    // حذف شحنة
   // public function destroy(Request $request, $shipId,$userId)
    //{
    //      $userId = $request->user_id;
    //   //  $request->validate([
    //      //   'user_id' => 'required|exists:users,id',
    //   //  ]);

    //     $shipping = Shipping::where('id', $id)
    //         ->where('user_id', $request->user_id)
    //         ->firstOrFail();

    //    // if (in_array($shipping->shipment_status, ['تم الشحن', 'تم التوصيل'])) {
    //     //    return response()->json(['message' => 'لا يمكن حذف شحنة تم شحنها أو توصيلها'], 403);
    //    // }

    //     $shipping->delete();

    //     return response()->json(['message' => 'تم حذف الشحنة بنجاح']);

//     public function sttore(Request $request): JsonResponse
// {

//     // التحقق من صحة البيانات الواردة
//     $request->validate([
//         'trip_id' => 'required|exists:plans,id',
//         'user_id' => 'required|exists:users,id',
//     ]);

//     $userId = $request->user_id;

//     // جلب خطة الاشتراك مع التحقق إنها موجودة
//     $ship = Trip::find($request->trip_id);

//     if (!$ship) {
//         return response()->json([
//             'success' => false,
//             'message' => 'الخطة غير موجودة.',
//         ], 404);
//     }

//     // ممكن هنا تضيف تحقق إضافي: هل الشركة مرتبطة بالمستخدم؟ حسب حاجتك
//  $shipping = Shipping::create([
//         'user_id' => $userId,
//         'trip_id' => $request->trip_id,
//         'name_user_to' => $request->name_user_to,
//         'phone_to' => $request->phone_to,
//         'national_number_to' => $request->national_number_to,
//     ]);
//      foreach ($request->items as $item) {
//         $shipping->items()->create($item);
//     }
//     // إنشاء الاشتراك الجديد
//     // $shipp = Shipping::create([
//     //     'user_id' => $userId,
//     //     'trip_id' => $shipp->id,
//     //     'start_at' => now(),
//     //     'end_at' => now()->addDays($plan->duration_days ?? 30), // إذا duration_days موجودة في plans
//     // ]);

//     return response()->json([
//         'success' => true,
//         'message' => 'تم إنشاء الاشتراك بنجاح',
//        //'data' => $shipping,
//     ], 201);}


 public function destroy(Request $request, $shipId, $userId)
{
    $ship = Shipping::where('id', $shipId)
        ->where('user_id', $userId)
        ->firstOrFail();

    // التحقق من حالة الشحنة
    if ($ship->shipment_status !== 'قيد المراجعة') {
        return response()->json([
            'success' => false,
            'message' => 'لا يمكن حذف الشحنة إلا إذا كانت حالتها "قيد المراجعة".'
        ], 403);
    }

    // حذف الشحنة
    $ship->delete();

    return response()->json([
        'success' => true,
        'message' => 'تم حذف الشحنة بنجاح.'
    ]);
}
}
