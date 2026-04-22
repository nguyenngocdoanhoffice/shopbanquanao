@extends('layouts.admin')

@section('content')
    <div class="mb-4">
        <h2 class="mb-1">Sửa sản phẩm</h2>
        <p class="text-muted mb-0">Cập nhật thông tin và giá bán.</p>
    </div>

    <div class="admin-card p-4">
        <form method="post" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="mb-3">
                <label class="form-label">Danh mục</label>
                <select class="form-select" name="category_id" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected($product->category_id === $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Tên sản phẩm</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Giá nhập</label>
                <input type="number" step="0.01" name="import_price" class="form-control" value="{{ old('import_price', $product->import_price) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Giá bán</label>
                <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tồn kho</label>
                <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" min="0" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Mô tả</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $product->description) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Kích cỡ (phân cách bởi dấu phẩy)</label>
                <input type="text" name="size" class="form-control" value="{{ old('size', $product->size) }}" placeholder="S, M, L, XL">
            </div>
            <div class="mb-3">
                <label class="form-label">Ảnh sản phẩm</label>
                <input type="file" name="image" class="form-control" accept="image/*">
                @if ($product->image)
                    @php
                        $imageUrl = \Illuminate\Support\Str::startsWith($product->image, ['http://', 'https://'])
                            ? $product->image
                            : \Illuminate\Support\Facades\Storage::url($product->image);
                    @endphp
                    <img src="{{ $imageUrl }}" class="img-fluid rounded-3 mt-3" style="max-height: 200px;" alt="{{ $product->name }}">
                @endif
            </div>
            <button class="btn btn-dark" type="submit">Cập nhật</button>
            <a class="btn btn-outline-secondary" href="{{ route('admin.products.index') }}">Hủy</a>
        </form>
    </div>
@endsection
