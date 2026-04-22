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
                <input type="number" name="discount_percent" class="form-control" value="{{ old('discount_percent') }}" min="1" max="100">
            </div>
            <div class="mb-3">
                <label class="form-label">Giảm tiền</label>
                <input type="number" name="discount_amount" class="form-control" value="{{ old('discount_amount') }}" min="0" step="0.01">
            </div>
            <div class="mb-3">
                <label class="form-label">Hết hạn</label>
                <input type="date" name="expired_at" class="form-control" value="{{ old('expired_at') }}">
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" checked>
                <label class="form-check-label" for="is_active">Kích hoạt</label>
            </div>
            <button class="btn btn-dark" type="submit">Lưu</button>
            <a class="btn btn-outline-secondary" href="{{ route('admin.coupons.index') }}">Hủy</a>
        </form>
    </div>
@endsection
