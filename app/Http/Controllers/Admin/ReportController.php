<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $reportType = $request->input('report_type', 'day');
        $rawReportDate = (string) $request->input('report_date', '');
        $reportDate = '';
        $reportLabel = '';

        if ($reportType === 'month') {
            $reportDate = preg_match('/^\d{4}-\d{2}$/', $rawReportDate)
                ? $rawReportDate
                : now()->format('Y-m');
        } elseif ($reportType === 'year') {
            $reportDate = preg_match('/^\d{4}$/', $rawReportDate)
                ? $rawReportDate
                : now()->format('Y');
        } else {
            $reportType = 'day';
            $reportDate = preg_match('/^\d{4}-\d{2}-\d{2}$/', $rawReportDate)
                ? $rawReportDate
                : now()->toDateString();
        }

        $ordersQuery = Order::with(['user', 'items.product'])
            ->where('status', 'completed');

        if ($reportType === 'month') {
            $target = Carbon::createFromFormat('Y-m', $reportDate);
            $ordersQuery->whereYear('created_at', $target->year)
                ->whereMonth('created_at', $target->month);
            $reportLabel = 'Tháng ' . $target->format('m/Y');
        } elseif ($reportType === 'year') {
            $target = Carbon::createFromFormat('Y', $reportDate);
            $ordersQuery->whereYear('created_at', $target->year);
            $reportLabel = 'Năm ' . $target->format('Y');
        } else {
            $target = Carbon::parse($reportDate);
            $ordersQuery->whereDate('created_at', $target->toDateString());
            $reportLabel = 'Ngày ' . $target->format('d/m/Y');
        }

        $reportTotal = (clone $ordersQuery)->sum('total');
        $orders = $ordersQuery->latest()->get();

        // Tinh lai/lo: tong tien sau giam gia - tong gia nhap
        $costQuery = OrderItem::query()
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.status', 'completed');

        if ($reportType === 'month') {
            $target = Carbon::createFromFormat('Y-m', $reportDate);
            $costQuery->whereYear('orders.created_at', $target->year)
                ->whereMonth('orders.created_at', $target->month);
        } elseif ($reportType === 'year') {
            $target = Carbon::createFromFormat('Y', $reportDate);
            $costQuery->whereYear('orders.created_at', $target->year);
        } else {
            $target = Carbon::parse($reportDate);
            $costQuery->whereDate('orders.created_at', $target->toDateString());
        }

        $cost = $costQuery
            ->select(DB::raw('SUM(order_items.import_price * order_items.quantity) as cost'))
            ->value('cost');

        $profit = $reportTotal - ($cost ?? 0);

        // Top san pham ban chay
        $topSelling = OrderItem::query()
            ->with('product')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.status', 'completed')
            ->select('order_items.product_id', DB::raw('SUM(order_items.quantity) as sold_qty'))
            ->groupBy('order_items.product_id')
            ->orderByDesc('sold_qty')
            ->take(5)
            ->get();

        // San pham ban it (ke ca so luong = 0)
        $lowSelling = Product::query()
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->leftJoin('orders', function ($join) {
                $join->on('orders.id', '=', 'order_items.order_id')
                    ->where('orders.status', 'completed');
            })
            ->select('products.id', 'products.name', DB::raw('COALESCE(SUM(order_items.quantity), 0) as sold_qty'))
            ->groupBy('products.id', 'products.name')
            ->orderBy('sold_qty')
            ->take(5)
            ->get();

        return view('admin.reports.index', compact(
            'reportType',
            'reportDate',
            'reportLabel',
            'reportTotal',
            'orders',
            'profit',
            'topSelling',
            'lowSelling'
        ));
    }
}
