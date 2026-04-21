@extends('layouts.admin')

@section('content')
    <div class="mb-4">
        <h2 class="mb-1">Báo cáo bán hàng</h2>
        <p class="text-muted mb-0">Chỉ tính các đơn hàng đã hoàn thành.</p>
    </div>

    <div class="admin-card p-4 mb-4">
        <form class="row g-3 align-items-end" method="get" action="{{ route('admin.reports.index') }}">
            <div class="col-12 col-md-3">
                <label class="form-label">Loại báo cáo</label>
                <select name="report_type" class="form-select">
                    <option value="day" @selected($reportType === 'day')>Theo ngày</option>
                    <option value="month" @selected($reportType === 'month')>Theo tháng</option>
                    <option value="year" @selected($reportType === 'year')>Theo năm</option>
                </select>
            </div>
            <div class="col-12 col-md-3">
                <label class="form-label">Thời gian</label>
                <input
                    class="form-control"
                    type="{{ $reportType === 'year' ? 'number' : ($reportType === 'month' ? 'month' : 'date') }}"
                    name="report_date"
                    value="{{ $reportDate }}"
                    min="2000"
                >
            </div>
            <div class="col-12 col-md-3">
                <button class="btn btn-outline-dark w-100" type="submit">Xem báo cáo</button>
            </div>
            <div class="col-12 col-md-3 text-md-end">
                <div class="text-muted">{{ $reportLabel }}</div>
                <div class="fs-4 fw-semibold">{{ number_format($reportTotal, 0) }} VND</div>
            </div>
        </form>
    </div>

    <div class="admin-card p-4">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Khách hàng</th>
                        <th>Email</th>
                        <th>Tổng</th>
                        <th>Ngày tạo</th>
                        <th>Đơn hàng</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $order->user?->name }}</td>
                            <td>{{ $order->user?->email }}</td>
                            <td>{{ number_format($order->total, 0) }} VND</td>
                            <td>{{ $order->created_at?->format('Y-m-d') }}</td>
                            <td>
                                <div class="small text-muted">
                                    @if ($order->phone)
                                        <div>SĐT: {{ $order->phone }}</div>
                                    @endif
                                    @if ($order->address)
                                        <div>Địa chỉ: {{ $order->address }}</div>
                                    @endif
                                </div>
                                <ul class="mb-0 mt-2">
                                    @foreach ($order->items as $item)
                                        <li>{{ $item->product?->name }} x {{ $item->quantity }}</li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-muted">Không có đơn hàng phù hợp.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
