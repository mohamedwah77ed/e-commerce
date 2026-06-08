@extends('backend.layouts.master')

@section('title', 'Products')

@section('content')

<div class="container py-4">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="mb-0">Products</h4>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">+ Add Product</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>{{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}</td>
                    <td>
                        @if($product->first_image)
                            <img src="{{ asset('uploads/' . $product->first_image) }}" alt="{{ $product->title }}" width="60" class="rounded">
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>{{ $product->title }}</td>
                    <td>{{ $product->cat_info->title ?? '—' }}</td>
                    <td>
                        @if($product->discount && $product->discount > 0)
                            <span class="text-decoration-line-through text-muted">${{ number_format($product->price, 2) }}</span>
                            <br>
                            <span class="text-danger fw-bold">${{ number_format($product->final_price, 2) }}</span>
                        @else
                            ${{ number_format($product->price, 2) }}
                        @endif
                    </td>
                    <td>
                        @if($product->stock > 10)
                            <span class="badge bg-success">{{ $product->stock }}</span>
                        @elseif($product->stock > 0)
                            <span class="badge bg-warning text-dark">{{ $product->stock }}</span>
                        @else
                            <span class="badge bg-danger">Out of Stock</span>
                        @endif
                    </td>
                    <td>
                        @if($product->status === 'active')
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.products.show', $product->slug) }}" class="btn btn-sm btn-outline-info">View</a>
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>

                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Delete this product?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">No products found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $products->links() }}
    </div>

</div>

@endsection
