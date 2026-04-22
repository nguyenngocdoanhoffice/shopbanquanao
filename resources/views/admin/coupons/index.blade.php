@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Mã giảm giá</h2>
            <p class="text-muted mb-0">Tạo và quản lý mã giảm giá.</p>
        </div>
        <a class="btn btn-dark" href="{{ route('admin.coupons.create') }}">Thêm mã</a>
    </div>

    <div class="admin-card p-4">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã</th>
                        <th>Giảm %</th>
                        <th>Giảm tiền</th>
                        <th>Hết hạn</th>
                        <th>Trạng thái</th>
                        <th width="160"></th>
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
                            <td>{{ $coupon->is_active ? 'Đang dùng' : 'Tạm tắt' }}</td>
                            <td class="d-flex gap-2">
                                <a class="btn btn-outline-secondary btn-sm" href="{{ route('admin.coupons.edit', $coupon) }}">Sửa</a>
                                <form method="post" action="{{ route('admin.coupons.destroy', $coupon) }}">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-outline-danger btn-sm" type="submit">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-muted">Chưa có mã giảm giá.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
