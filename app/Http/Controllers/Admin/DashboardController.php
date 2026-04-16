<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Testimonial;
use Illuminate\Support\Facades\DB;
use Lunar\Models\Customer;
use Lunar\Models\Order;
use Lunar\Models\Product;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $revenueByCurrency = Order::query()
            ->whereIn('status', ['payment-received', 'dispatched'])
            ->select('currency_code', DB::raw('SUM(total) as sum'), DB::raw('COUNT(*) as n'))
            ->groupBy('currency_code')
            ->get()
            ->keyBy('currency_code');

        return view('admin.dashboard.index', [
            'productsCount' => Product::count(),
            'ordersCount' => Order::count(),
            'pendingOrders' => Order::where('status', 'payment-offline')->count(),
            'customersCount' => Customer::count(),
            'pagesCount' => Page::count(),
            'testimonialsCount' => Testimonial::count(),
            'revenueEur' => ($revenueByCurrency->get('EUR')->sum ?? 0) / 100,
            'revenueEurCount' => $revenueByCurrency->get('EUR')->n ?? 0,
            'revenueUsd' => ($revenueByCurrency->get('USD')->sum ?? 0) / 100,
            'revenueUsdCount' => $revenueByCurrency->get('USD')->n ?? 0,
            'recentOrders' => Order::latest('placed_at')->take(8)->get(),
        ]);
    }
}
