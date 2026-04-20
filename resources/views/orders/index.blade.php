@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="mb-1">Đơn hàng của tôi</h2>
            <p class="text-muted mb-0">Theo dõi đơn mua gần đây.</p>
        </div>
    </div>

    @if ($orders->isEmpty())
        <p class="text-muted">Bạn chưa có đơn hàng.</p>
    @else
        <div class="bg-white p-3 p-lg-4 rounded-4 shadow-sm">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Trạng thái</th>
                            <th>Tổng</th>
                            <th>Ngày tạo</th>
                            <th>Sản phẩm</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
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
                                <td>{{ number_format($order->total, 0) }} VND</td>
                                <td>{{ $order->created_at?->format('Y-m-d') }}</td>
                                <td>
                                    <ul class="mb-0">
                                        @foreach ($order->items as $item)
                                            <li>{{ $item->product?->name }} x {{ $item->quantity }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
