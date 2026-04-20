@extends('layouts.admin')

@section('content')
    <div class="mb-4">
        <h2 class="mb-1">Orders</h2>
        <p class="text-muted mb-0">Track the latest customer activity.</p>
    </div>

    <div class="admin-card p-4">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Items</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->user?->name }}</td>
                            <td>{{ number_format($order->total, 0) }} VND</td>
                            <td><span class="badge bg-warning text-dark">{{ $order->status }}</span></td>
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
                            <td colspan="6" class="text-muted">No orders yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
