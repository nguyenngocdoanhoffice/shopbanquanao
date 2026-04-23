@extends('layouts.admin')

@section('content')
    <div class="mb-4">
        <h2 class="mb-1">Thêm mã giảm giá</h2>
        <p class="text-muted mb-0">Nhập thông tin mã giảm giá.</p>
    </div>

    <div class="admin-card p-4">
        <form method="post" action="{{ route('admin.coupons.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Mã</label>
                <input type="text" name="code" class="form-control" value="{{ old('code') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Giảm %</label>
                <input type="number" name="discount_percent" class="form-control" value="{{ old('discount_percent') }}" min="1" max="100" id="discount_percent">
            </div>
            <div class="mb-3">
                <label class="form-label">Giảm tiền</label>
                <input type="number" name="discount_amount" class="form-control" value="{{ old('discount_amount') }}" min="0" step="0.01" id="discount_amount">
            </div>
            <div class="mb-3">
                <label class="form-label">Hết hạn</label>
                <input type="date" name="expired_at" class="form-control" value="{{ old('expired_at') }}">
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" checked>
                <label class="form-check-label" for="is_active">Kích hoạt</label>
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="apply_all" value="1" id="apply_all" checked>
                <label class="form-check-label" for="apply_all">Áp dụng cho tất cả khách hàng</label>
            </div>

            <div class="mb-3">
                <label class="form-label">Chọn khách hàng (nếu không áp dụng tất cả)</label>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th width="60"></th>
                                <th>Họ tên</th>
                                <th>Đã mua</th>
                                <th>Tổng tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        <input class="form-check-input" type="checkbox" name="user_ids[]" value="{{ $user->id }}">
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->orders_count }}</td>
                                    <td>{{ number_format($user->total_spent ?? 0, 0) }} VND</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <button class="btn btn-dark" type="submit">Lưu</button>
            <a class="btn btn-outline-secondary" href="{{ route('admin.coupons.index') }}">Hủy</a>
        </form>
    </div>

    <script>
        const percentInput = document.getElementById('discount_percent');
        const amountInput = document.getElementById('discount_amount');

        const toggleDiscountInputs = () => {
            const hasPercent = percentInput.value.trim() !== '';
            const hasAmount = amountInput.value.trim() !== '';

            amountInput.disabled = hasPercent;
            percentInput.disabled = hasAmount;
        };

        percentInput.addEventListener('input', toggleDiscountInputs);
        amountInput.addEventListener('input', toggleDiscountInputs);
        toggleDiscountInputs();
    </script>
@endsection
