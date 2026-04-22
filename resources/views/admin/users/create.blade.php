@extends('layouts.admin')

@section('content')
    <div class="mb-4">
        <h2 class="mb-1">Thêm khách hàng</h2>
        <p class="text-muted mb-0">Nhập thông tin tài khoản.</p>
    </div>

    <div class="admin-card p-4">
        <form method="post" action="{{ route('admin.users.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Họ và tên</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Mật khẩu</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="is_admin" value="1" id="is_admin">
                <label class="form-check-label" for="is_admin">Tài khoản admin</label>
            </div>
            <button class="btn btn-dark" type="submit">Lưu</button>
            <a class="btn btn-outline-secondary" href="{{ route('admin.users.index') }}">Hủy</a>
        </form>
    </div>
@endsection
