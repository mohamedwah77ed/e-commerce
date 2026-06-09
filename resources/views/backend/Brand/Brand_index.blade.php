@extends('backend.layouts.master')


@section('title', 'Brands')

{{-- أضف السطر ده هنا --}}
@section('content')
@section('title', 'Brands')

<div class="container py-4">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="mb-0">Brands</h4>
        <a href="{{ route('admin.brand.create') }}" class="btn btn-success btn-sm">+ Add Brand</a>
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
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($brands as $brand)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $brand->title }}</td>
                    <td><span class="text-muted">{{ $brand->slug }}</span></td>
                    <td>
                        @if($brand->status === 'active')
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.brand.edit', $brand->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>

                        <form action="{{ route('admin.brand.destroy', $brand->id) }}" method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Are you sure you want to delete this brand?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">No brands found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $brands->links() }}
    </div>

</div>

@endsection
