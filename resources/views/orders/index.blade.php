@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="mb-1">My orders</h2>
            <p class="text-muted mb-0">Track your recent purchases.</p>
        </div>
    </div>

    @if ($orders->isEmpty())
        <p class="text-muted">You have no orders yet.</p>
    @else
        <div class="bg-white p-3 p-lg-4 rounded-4 shadow-sm">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Created</th>
                            <th>Items</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td><span class="badge bg-warning text-dark">{{ $order->status }}</span></td>
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
