<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

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

        return view('admin.reports.index', compact('reportType', 'reportDate', 'reportLabel', 'reportTotal', 'orders'));
    }
}
