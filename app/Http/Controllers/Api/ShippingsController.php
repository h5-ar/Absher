<?php

namespace App\Http\Controllers;


use App\Models\Shipping;
use App\Models\ItemShipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShippingsController extends Controller
{
    //
public function store(Request $request)
   {
       $request->validate([
           'user_id' => 'required|exists:users,id',
           'trip_id' => 'required|exists:trips,id',
           'name_user_to' => 'required|string',
           'phone_to' => 'required|string',
           'national_number_to' => 'required|string',
           'items' => 'required|array|min:1',
           'items.*.description_item' => 'required|string',
           'items.*.material_value' => 'required|string',
           'items.*.size' => 'required|in:صغير,متوسط,كبير',
       ]);

       $shipping = Shipping::create($request->only([
           'user_id', 'trip_id', 'name_user_to', 'phone_to', 'national_number_to'
       ]));

       foreach ($request->items as $item) {
           $shipping->items()->create($item);
       }

       return response()->json(['message' => 'تم إنشاء الشحنة بنجاح'], 201);
   }
    //  عرض جميع الشحنات للمتخدم
    public function index($id)
    {
        $shippings = Shipping::with('trip.path')
            ->where('user_id', $id)
            ->get()
            ->map(function ($shipping) {
                $path = optional(optional($shipping->trip)->path);
                return [
                    'shipping_id' => $shipping->id,
                    'from' => $path->from ?? 'غير معروف',
                    'to' => collect([
                        $path->to5, $path->to4, $path->to3, $path->to2, $path->to1
                    ])->first(fn($to) => !empty($to)) ?? 'غير معروف',
                    'status' => $shipping->shipment_status,
                ];
            });

        return response()->json($shippings);
    }


   // عرض تفاصيل شحنة واحدة
    public function show(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $shipping = Shipping::with(['items', 'trip.path'])
            ->where('id', $id)
            ->where('user_id', $request->user_id)
            ->firstOrFail();

        $path = $shipping->trip->path;
         //استخراج اخر جهة وصلا
        $lastDestination = collect([
            $path->to5, $path->to4, $path->to3, $path->to2, $path->to1
        ])->first(fn($to) => !empty($to)) ?? 'غير معروف';

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
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name_user_to' => 'sometimes|required|string|max:100',
            'phone_to' => 'sometimes|required|string|max:10',
            'national_number_to' => 'sometimes|required|string|max:30',
            'shipment_status' => 'sometimes|in:قيد المراجعة,بانتظار الرحلة,تم الشحن,تم التوصيل,ملغاة',
            'items' => 'sometimes|array|min:1',
            'items.*.description_item' => 'required_with:items|string',
            'items.*.material_value' => 'required_with:items|string',
            'items.*.size' => 'required_with:items|in:صغير,متوسط,كبير',
        ]);

        $shipping = Shipping::where('id', $id)
            ->where('user_id', $request->user_id)
            ->firstOrFail();

        $shipping->update($request->only([
            'name_user_to',
            'phone_to',
            'national_number_to',
            'shipment_status',
        ]));
        //تحديث العناصر اذا تمررت
        if ($request->has('items')) {
            //حذف القديمين
            $shipping->items()->delete();
         //اضافة الجداد
         foreach ($request->items as $item) {
            $shipping->items()->create([
                'description_item'      => $item['description_item'],
                'material_value' => $item['material_value'],
                'size'           => $item['size'],
            ]);
        }
        }

        return response()->json(['message' => 'تم تحديث الشحنة بنجاح']);
    }

    // حذف شحنة
    public function destroy(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $shipping = Shipping::where('id', $id)
            ->where('user_id', $request->user_id)
            ->firstOrFail();

        if (in_array($shipping->shipment_status, ['تم الشحن', 'تم التوصيل'])) {
            return response()->json(['message' => 'لا يمكن حذف شحنة تم شحنها أو توصيلها'], 403);
        }

        $shipping->delete();

        return response()->json(['message' => 'تم حذف الشحنة بنجاح']);
    }
}

