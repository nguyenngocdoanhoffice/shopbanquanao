@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Products</h2>
            <p class="text-muted mb-0">Manage your catalog and pricing.</p>
        </div>
        <a class="btn btn-dark" href="{{ route('admin.products.create') }}">Add product</a>
    </div>

    <div class="admin-card p-4">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th width="160"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>#{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category?->name }}</td>
                            <td>{{ number_format($product->price, 0) }} VND</td>
                            <td class="d-flex gap-2">
                                <a class="btn btn-outline-secondary btn-sm" href="{{ route('admin.products.edit', $product) }}">Edit</a>
                                <form method="post" action="{{ route('admin.products.destroy', $product) }}">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-outline-danger btn-sm" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-muted">No products yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
