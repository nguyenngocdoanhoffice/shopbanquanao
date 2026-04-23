@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="mb-1">Mã giảm giá</h2>
            <p class="text-muted mb-0">Các mã dành riêng cho bạn.</p>
        </div>
    </div>

    <div class="bg-white p-3 p-lg-4 rounded-4 shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã</th>
                        <th>Giảm %</th>
                        <th>Giảm tiền</th>
                        <th>Hết hạn</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($coupons as $coupon)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $coupon->code }}</td>
                            <td>{{ $coupon->discount_percent ?? '-' }}</td>
                            <td>{{ $coupon->discount_amount ? number_format($coupon->discount_amount, 0) . ' VND' : '-' }}</td>
                            <td>{{ $coupon->expired_at?->format('Y-m-d') ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-muted">Chưa có mã giảm giá.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
