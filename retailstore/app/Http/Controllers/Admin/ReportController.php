<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    // Show reports dashboard
    public function index()
    {
        // Total sales per day
        $salesPerDay = Order::select(
            DB::raw('DATE(order_date) as date'),
            DB::raw('SUM(total_amount) as total_sales')
        )
        ->groupBy('date')
        ->orderBy('date', 'desc')
        ->get();

        // Orders count per status
        $ordersPerStatus = Order::select(
            'order_status',
            DB::raw('COUNT(*) as total_orders')
        )
        ->groupBy('order_status')
        ->get();

        // Inventory summary
        $inventorySummary = Product::with('inventory')->get();

        return view('admin.reports.index', compact('salesPerDay', 'ordersPerStatus', 'inventorySummary'));
    }
}
