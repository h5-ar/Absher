<?php

namespace App\Http\Controllers;

use App\Models\Shipping;
use App\Models\ItemShipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShippingController extends Controller
{
    // إنشاء شحنة جديدة مع وصف الغرض
    public function store(Request $request)
{
    $request->validate([
        'trip_id' => 'required|exists:trips,id',
        'size' => 'required|string',
        'name_user_to' => 'required|string|max:100',
        'phone_user_to' => 'required|string|max:10',
        'national_number_user_to' => 'required|string|max:30',
        'items' => 'required|array|min:1',
        'items.*.material_value' => 'required|string',
        'items.*.description_item' => 'nullable|string|max:255',
    ]);

    $shipping = Shipping::create([
        'user_id' => 2,
        'trip_id' => $request->trip_id,
        'size' => $request->size,
        'shipment_status' => 'ملغاة',
        'name_user_to' => $request->name_user_to,
        'phone_user_to' => $request->phone_user_to,
        'national_number_user_to' => $request->national_number_user_to,
    ]);

    foreach ($request->items as $item) {
        ItemShipping::create([
            'shipping_id' => $shipping->id,
            'material_value' => $item['material_value'],
            'description_item' => $item['description_item'] ?? null,
        ]);
    }

    return response()->json([
        'message' => 'تم إنشاء الشحنة بنجاح',
        'shipping_id' => $shipping->id
    ]);
}
    //  عرض جميع الشحنات للمتخدم 
    public function index()
{
    $shippings = \App\Models\Shipping::with('trip.path')
      //  ->where('user_id', auth()->id())
        ->whereIn('shipment_status', ['بانتظار', 'تم الشحن'])
        ->get()
        ->map(function ($shipping) {
            $path = $shipping->trip->path;

            return [
                'shipping_id' => $shipping->id,
                'from' => $path->from ?? 'غير معروف',
                'to' => $path->last_destination ?? 'غير معروف',
                'status' => $shipping->shipment_status,
            ];
        });

    return response()->json($shippings);
}

   
    public function show($id)
{
    $shipping = \App\Models\Shipping::with([
        'item_Shipping',   // الأغراض
        'trip.path'        // معلومات الرحلة + المسار
    ])
    ->where('id', $id)
    ->where('user_id', auth()->id()) // بس شحنات المستخدم الحالي
    ->firstOrFail();

    return response()->json([
        'shipping_id' => $shipping->id,
        'trip_id'=>$shipping->trip_id,
        'size' => $shipping->size,
        'status' => $shipping->shipment_status,
        'receiver_name' => $shipping->name_user_to,
        'receiver_phone' => $shipping->phone_user_to,
        'trip_date' => $shipping->trip->trip_date ?? null,
        'from' => $shipping->trip->path->from ?? 'غير معروف',
        'to' => $shipping->trip->path->last_destination ?? 'غير معروف',
        'items' => $shipping->item_Shipping->map(function ($item) {
            return [
                'material_value' => $item->material_value,
                'description' => $item->description_item,
            ];
        }),
    ]);
}

    // تحديث شحنة
    public function update(Request $request, $id)
{
    $request->validate([
        'size' => 'required|string',
        'name_user_to' => 'required|string|max:100',
        'phone_user_to' => 'required|string|max:10',
        'national_number_user_to' => 'required|string|max:30',
        'items' => 'required|array|min:1',
        'items.*.material_value' => 'required|string',
        'items.*.description_item' => 'nullable|string|max:255',
    ]);

    $shipping = Shipping::where('id', $id)
        //->where('user_id', auth()->id())
        ->firstOrFail();

    // تحديث بيانات الشحنة
    $shipping->update([
        'size' => $request->size,
        'name_user_to' => $request->name_user_to,
        'phone_user_to' => $request->phone_user_to,
        'national_number_user_to' => $request->national_number_user_to,
    ]);

    // حذف الأغراض القديمة المرتبطة
    $shipping->item_Shipping()->delete();

    // إنشاء الأغراض الجديدة
    foreach ($request->items as $item) {
        ItemShipping::create([
            'shipping_id' => $shipping->id,
            'material_value' => $item['material_value'],
            'description_item' => $item['description_item'] ?? null,
        ]);
    }

    return response()->json(['message' => 'تم تعديل الشحنة والأغراض بنجاح']);
}

    // حذف شحنة
    public function destroy($id)
{
    $shipping = \App\Models\Shipping::where('id', $id)
        //->where('user_id', auth()->id())
        ->firstOrFail();

    $shipping->delete(); // بسبب onDelete('cascade') الأغراض بتنحذف تلقائياً

    return response()->json(['message' => 'تم حذف الشحنة بنجاح']);

    if (in_array($shipping->shipment_status, ['تم الشحن', 'تم التوصيل'])) {
        return response()->json(['message' => 'لا يمكن حذف شحنة تم شحنها أو توصيلها'], 403);
    }
}

}
