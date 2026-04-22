@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Khách hàng</h2>
            <p class="text-muted mb-0">Quản lý tài khoản người dùng.</p>
        </div>
        <a class="btn btn-dark" href="{{ route('admin.users.create') }}">Thêm khách hàng</a>
    </div>

    <div class="admin-card p-4">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Số đơn</th>
                        <th>Tổng mua</th>
                        <th>Quyền</th>
                        <th width="160"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->orders_count }}</td>
                            <td>{{ number_format($user->total_spent ?? 0, 0) }} VND</td>
                            <td>{{ $user->is_admin ? 'Admin' : 'User' }}</td>
                            <td class="d-flex gap-2">
                                <a class="btn btn-outline-secondary btn-sm" href="{{ route('admin.users.edit', $user) }}">Sửa</a>
                                <form method="post" action="{{ route('admin.users.destroy', $user) }}">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-outline-danger btn-sm" type="submit">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-muted">Chưa có khách hàng.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
