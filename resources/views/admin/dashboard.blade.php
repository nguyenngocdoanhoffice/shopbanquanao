@extends('layouts.admin')

@section('content')
    <div class="row g-4 mb-4">
        <div class="col-12 col-md-6 col-xl-3">
            <div class="admin-card p-4 fade-up" style="--delay: 0s;">
                <div class="text-muted">Products</div>
                <div class="display-6 fw-semibold">{{ $stats['products'] }}</div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="admin-card p-4 fade-up" style="--delay: 0.1s;">
                <div class="text-muted">Categories</div>
                <div class="display-6 fw-semibold">{{ $stats['categories'] }}</div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="admin-card p-4 fade-up" style="--delay: 0.2s;">
                <div class="text-muted">Orders</div>
                <div class="display-6 fw-semibold">{{ $stats['orders'] }}</div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="admin-card p-4 fade-up" style="--delay: 0.3s;">
                <div class="text-muted">Revenue</div>
                <div class="display-6 fw-semibold">{{ number_format($stats['revenue'], 0) }} VND</div>
            </div>
        </div>
    </div>

    <div class="admin-card p-4 fade-up" style="--delay: 0.35s;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Latest orders</h4>
            <a class="btn btn-outline-dark btn-sm" href="{{ route('admin.orders.index') }}">View all</a>
        </div>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($latestOrders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->user?->name }}</td>
                            <td>{{ number_format($order->total, 0) }} VND</td>
                            <td><span class="badge bg-warning text-dark">{{ $order->status }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-muted">No orders yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
