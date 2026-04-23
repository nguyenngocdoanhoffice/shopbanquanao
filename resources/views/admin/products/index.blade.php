@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Sản phẩm</h2>
            <p class="text-muted mb-0">Quản lý sản phẩm và giá bán.</p>
        </div>
        <a class="btn btn-dark" href="{{ route('admin.products.create') }}">Thêm sản phẩm</a>
    </div>

    <div class="admin-card p-4">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên</th>
                        <th>Danh mục</th>
                        <th>Giá bán</th>
                        <th>Tồn kho</th>
                        <th width="160"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category?->name }}</td>
                            <td>{{ number_format($product->price, 0) }} VND</td>
                            <td>
                                <span class="fw-semibold">{{ $product->stock }}</span>
                                @if ($product->stock === 0)
                                    <div class="text-danger small">Cần nhập thêm</div>
                                @elseif ($product->stock < 50)
                                    <div class="text-warning small">Sắp hết hàng</div>
                                @endif
                            </td>
                            <td class="d-flex gap-2">
                                <a class="btn btn-outline-secondary btn-sm" href="{{ route('admin.products.edit', $product) }}">Sửa</a>
                                <form method="post" action="{{ route('admin.products.destroy', $product) }}">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-outline-danger btn-sm" type="submit">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-muted">Chưa có sản phẩm.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
