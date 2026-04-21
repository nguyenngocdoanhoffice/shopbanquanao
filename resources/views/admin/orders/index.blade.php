@extends('layouts.admin')

@section('content')
    <div class="mb-4">
        <h2 class="mb-1">Đơn hàng</h2>
        <p class="text-muted mb-0">Theo dõi hoạt động khách hàng.</p>
    </div>

    <div class="admin-card p-4">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Khách hàng</th>
                        <th>Tổng</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th>Sản phẩm</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $order->user?->name }}</td>
                            <td>{{ number_format($order->total, 0) }} VND</td>
                            <td>
                                @php
                                    $isCompleted = $order->status === 'completed';
                                @endphp
                                <form method="post" action="{{ route('admin.orders.update', $order) }}" class="d-flex gap-2 align-items-center">
                                    @csrf
                                    @method('patch')
                                    @php
                                        $statusLabels = [
                                            'pending' => 'Chờ xử lý',
                                            'processing' => 'Đang xử lý',
                                            'shipping' => 'Đang giao',
                                            'completed' => 'Hoàn thành',
                                            'canceled' => 'Đã hủy',
                                        ];
                                    @endphp
                                    <select name="status" class="form-select form-select-sm" style="min-width: 140px;" @disabled($isCompleted)>
                                        @foreach ($statusLabels as $status => $label)
                                            <option value="{{ $status }}" @selected($order->status === $status)>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-outline-dark btn-sm" type="submit" @disabled($isCompleted)>
                                        Lưu
                                    </button>
                                </form>
                            </td>
                            <td>{{ $order->created_at?->format('Y-m-d') }}</td>
                            <td>
                                <ul class="mb-0">
                                    @foreach ($order->items as $item)
                                        <li>{{ $item->product?->name }} x {{ $item->quantity }}</li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-muted">Chưa có đơn hàng.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
