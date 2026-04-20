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
                            <td>
                                <form method="post" action="{{ route('admin.orders.update', $order) }}" class="d-flex gap-2 align-items-center">
                                    @csrf
                                    @method('patch')
                                    <select name="status" class="form-select form-select-sm" style="min-width: 140px;">
                                        @foreach (['pending', 'processing', 'shipping', 'completed', 'canceled'] as $status)
                                            <option value="{{ $status }}" @selected($order->status === $status)>
                                                {{ ucfirst($status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-outline-dark btn-sm" type="submit">Save</button>
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
                            <td colspan="6" class="text-muted">No orders yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
