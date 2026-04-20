@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Danh mục</h2>
            <p class="text-muted mb-0">Nhóm sản phẩm để dễ tìm kiếm.</p>
        </div>
        <a class="btn btn-dark" href="{{ route('admin.categories.create') }}">Thêm danh mục</a>
    </div>

    <div class="admin-card p-4">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th width="160"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td>#{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td class="d-flex gap-2">
                                <a class="btn btn-outline-secondary btn-sm" href="{{ route('admin.categories.edit', $category) }}">Sửa</a>
                                <form method="post" action="{{ route('admin.categories.destroy', $category) }}">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-outline-danger btn-sm" type="submit">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-muted">Chưa có danh mục.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
