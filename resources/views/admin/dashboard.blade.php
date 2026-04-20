@extends('layouts.admin')

@section('content')
    <div class="row g-4 mb-4">
        <div class="col-12 col-md-6 col-xl-3">
            <div class="admin-card p-4 fade-up" style="--delay: 0s;">
                <div class="text-muted">Sản phẩm</div>
                <div class="display-6 fw-semibold">{{ $stats['products'] }}</div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="admin-card p-4 fade-up" style="--delay: 0.1s;">
                <div class="text-muted">Danh mục</div>
                <div class="display-6 fw-semibold">{{ $stats['categories'] }}</div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="admin-card p-4 fade-up" style="--delay: 0.2s;">
                <div class="text-muted">Đơn hàng</div>
                <div class="display-6 fw-semibold">{{ $stats['orders'] }}</div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="admin-card p-4 fade-up" style="--delay: 0.3s;">
                <div class="text-muted">Doanh thu</div>
                <div class="display-6 fw-semibold">{{ number_format($stats['revenue'], 0) }} VND</div>
            </div>
        </div>
    </div>

    <div class="admin-card p-4 fade-up" style="--delay: 0.35s;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Đơn hàng mới nhất</h4>
            <a class="btn btn-outline-dark btn-sm" href="{{ route('admin.orders.index') }}">Xem tất cả</a>
        </div>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Khách hàng</th>
                        <th>Tổng</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($latestOrders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $order->user?->name }}</td>
                            <td>{{ number_format($order->total, 0) }} VND</td>
                            <td>
                                @php
                                    $statusLabels = [
                                        'pending' => 'Chờ xử lý',
                                        'processing' => 'Đang xử lý',
                                        'shipping' => 'Đang giao',
                                        'completed' => 'Hoàn thành',
                                        'canceled' => 'Đã hủy',
                                    ];
                                @endphp
                                <span class="badge bg-warning text-dark">
                                    {{ $statusLabels[$order->status] ?? $order->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-muted">Chưa có đơn hàng.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
