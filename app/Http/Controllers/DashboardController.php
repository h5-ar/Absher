<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
    {
        //     $totalOrdersCount = Order::count();

        //     $totalDeliveredOrdersCount = Order::where('status', OrderStatus::COMPLETED)
        //         ->count();

        //     $totalSalesGroupedByMonth = Order::whereNotIn('status', [OrderStatus::REJECTED, OrderStatus::REFUND, OrderStatus::PENDING])
        //         ->whereBetween('created_at', [now()->startOfYear(), now()])
        //         ->get()
        //         ->groupBy(fn ($val) => $val->created_at->format('Y-m'));

        //     foreach ($totalSalesGroupedByMonth as $key => $totalSalesPerMonth) {
        //         $totalSalesGroupedByMonth[$key] = $totalSalesPerMonth->sum(fn ($order) => $order->total_price - $order->discount);
        //     }

        //     $totalItemsGroupedByMonth = OrderItem::query()
        //         ->whereBetween('created_at', [now()->startOfYear(), now()])
        //         ->whereHas('order', function ($q) {
        //             $q->whereNotIn('status', [OrderStatus::REJECTED, OrderStatus::REFUND, OrderStatus::PENDING]);
        //         })
        //         ->get()
        //         ->groupBy(function ($val) {
        //             return $val->created_at->format('Y-m');
        //         });


        //         foreach ($totalItemsGroupedByMonth as $key => $totalItemsPerMonth) {
        //         $totalItemsGroupedByMonth[$key] = $totalItemsPerMonth->sum(fn ($orderItem) => $orderItem->purchase_price * $orderItem->product_quantity);
        //     }


        //     $totalProfits = ($totalSales = array_sum($totalSalesGroupedByMonth->toArray())) - array_sum($totalItemsGroupedByMonth->toArray());
        //     $profitsChartData = collect(range(1, now()->month))->map(function ($month) use ($totalSalesGroupedByMonth, $totalItemsGroupedByMonth) {
        //         $month = Carbon::create(null, $month, 1)->format('Y-m');
        //         if (!array_key_exists($month, $totalSalesGroupedByMonth->toArray())) {
        //             return $totalSalesGroupedByMonth[$month] = 0;
        //         }
        //         return $totalSalesGroupedByMonth[$month] - $totalItemsGroupedByMonth[$month];
        //     });

        //     $bestUsers = Cache::remember('bestUsers', 1440, fn () => User::withCount('orders')
        //         ->withSum('orders', 'total_price')
        //         ->with('attache')
        //         ->orderByDesc('orders_count')
        //         ->limit(30)
        //         ->get());

        //     $bestSellers = Cache::remember('bestSellers', 1440, fn () => Seller::withSum('orderItems', 'product_quantity')
        //         ->with('user')
        //         ->orderByDesc('order_items_sum_product_quantity')
        //         ->limit(30)
        //         ->get());

        //     $bestSellers->each(function ($seller) {
        //         return $seller->totalSales = OrderItem::whereRelation('stock', 'seller_id', $seller->id)
        //             ->select([DB::raw('SUM(product_quantity * purchase_price) as totalSales')])
        //             ->where('status', OrderItemStatus::APPROVED)->pluck('totalSales')[0];
        //     });

        //     $bestProducts = Cache::remember('bestProducts', 1440, fn () => ProductStock::withSum('orderItems', 'product_quantity')
        //         ->with(['product' => ['category', 'brand'], 'attache', 'seller.user'])
        //         ->orderByDesc('order_items_sum_product_quantity')
        //         ->limit(30)
        //         ->get());

        //     $activeProductsCount = Product::query()
        //         ->whereAll(['approved', 'published'], true)
        //         ->count();

        //     $activeOffersCount = Offer::query()
        //         ->where('is_active', true)
        //         ->count();

        //     $activeCouponsCount = Coupon::query()
        //         ->where('end_date', '>=', now())
        //         ->where('start_date', '<=', now())
        //         ->count();

        //     $usersCount = User::query()->count();

        //     $sellersCount = Seller::query()->whereAll(['active', 'verified'], true)->count();

        //     $staffsCount = User::query()->whereHas('roles', function ($q) {
        //         $q->whereIn('name', ModelsRole::whereNotIn('name', ['user', 'seller'])->pluck('name'));
        //     })->count();

        //     $ordersChartTrend = Trend::query(Order::query()
        //         ->where('status', OrderStatus::COMPLETED))
        //         ->between(
        //             start: now()->startOfYear(),
        //             end: now(),
        //         )
        //         ->perMonth()
        //         ->count();

        //     // $profitsChartTrend = Trend::query(OrderItem::query()
        //     //     ->withWhereHas('order', function ($q) {
        //     //         $q->whereNotIn('status', [OrderStatus::REJECTED, OrderStatus::REFUND, OrderStatus::PENDING]);
        //     //     }))
        //     //     ->between(
        //     //         start: now()->startOfYear(),
        //     //         end: now(),
        //     //     )
        //     //     ->perMonth()
        //     //     ->sum('(orders.total_price - orders.discount) - (purchase_price * product_quantity)');


        //     $productsChartTrend = Trend::query(Product::query()
        //         ->whereAll(['approved', 'published'], true))
        //         ->between(
        //             start: now()->startOfYear(),
        //             end: now(),
        //         )
        //         ->perMonth()
        //         ->count();

        //     $usersChartTrend = Trend::model(User::class)
        //         ->between(
        //             start: now()->startOfYear(),
        //             end: now(),
        //         )
        //         ->perMonth()
        //         ->count();

        //     $ordersChartData = $ordersChartTrend->map(fn (TrendValue $value) => $value->aggregate);
        //     // $profitsChartData = '';
        //     $productsChartData = $productsChartTrend->map(fn (TrendValue $value) => $value->aggregate);
        //     $usersChartData = $usersChartTrend->map(fn (TrendValue $value) => $value->aggregate);

        return view('Dashboard.Admin.dashboard');
        //         compact('totalOrdersCount', 'totalDeliveredOrdersCount', 'totalSales', 'totalProfits', 'bestSellers', 'bestProducts', 'bestUsers', 'activeProductsCount', 'activeOffersCount', 'activeCouponsCount', 'usersCount', 'sellersCount', 'staffsCount', 'ordersChartData', 'profitsChartData', 'productsChartData', 'usersChartData')
        //     );
    }

    public function switchLang()
    {
        $lang = match (app()->getLocale()) {
            'ar'    => 'en',
            'en'    => 'ar',
        };

        Session::put('lang', $lang);
        return redirect()->route('dashboard');
    }
    public function profile()
    {
        return 11;
    }
    
    public function settings()
    {
        return 11;
    }

    // public function settings()
    // {
    //     $settings = Setting::paginate();
    //     return view('Dashboard.Admin.Settings.index', compact('settings'));
    // }

    // public function updateSettings(Request $request, string $settingId)
    // {
    //     $setting =  Setting::findOrFail($settingId);

    //     $setting->update(['value' => $request->value]);

    //     Session::flash('successMessage', translate('Updated successfully'));
    //     return redirect()->back();
    // }


    // public function backupDatabase()
    // {
    //     // Set the database credentials
    //     $host     = env('DB_HOST');
    //     $database = env('DB_DATABASE');
    //     $username = env('DB_USERNAME');
    //     $password = env('DB_PASSWORD');

    //     // Set the path for the exported file
    //     $filename = env('APP_NAME') . '_' . date('Y-m-d_H-i-s') . '.sql';
    //     $path = storage_path('app/' . $filename);

    //     // Use mysqldump to export the database
    //     $command = sprintf(
    //         'mysqldump -h%s -u%s -p%s %s',
    //         $host,
    //         $username,
    //         $password,
    //         $database
    //     );

    //     $process = Process::fromShellCommandline($command);

    //     try {
    //         // Run the command
    //         $output = $process->mustRun()->getOutput();

    //         // Write the output to the file
    //         file_put_contents($path, $output);

    //         // Return the file for download
    //         return response()->download($path, $filename)->deleteFileAfterSend(true);
    //     } catch (ProcessFailedException $exception) {
    //         throw new \RuntimeException($exception->getMessage());
    //     }
    // }
}
