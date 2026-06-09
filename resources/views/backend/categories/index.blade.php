@extends('backend.layouts.master')

@section('title', 'Categories')

@section('content')

<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-0">Categories</h4>
            <small class="text-muted">{{ $categories->count() }} total categories</small>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Add Category
        </a>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Parent Categories --}}
    @php
        $parents = $categories->where('is_parent', 1)->where('parent_id', null);
        $children = $categories->where('is_parent', 0);
    @endphp

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3 d-flex align-items-center justify-content-between">
            <h6 class="mb-0 fw-semibold"><i class="bi bi-grid me-2 text-primary"></i>All Categories</h6>
            <div class="d-flex gap-2">
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                    Parents: {{ $parents->count() }}
                </span>
                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">
                    Sub: {{ $children->count() }}
                </span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">#</th>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Type</th>
                            <th>Parent</th>
                            <th>Added By</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                        <tr>
                            <td class="ps-3 text-muted">{{ $loop->iteration }}</td>

                            {{-- Title --}}
                            <td>
                                <div class="fw-medium">
                                    @if(!$category->is_parent)
                                        <span class="text-muted me-1">└</span>
                                    @endif
                                    {{ $category->title }}
                                </div>
                                @if($category->summary)
                                    <small class="text-muted">{{ Str::limit($category->summary, 50) }}</small>
                                @endif
                            </td>

                            {{-- Slug --}}
                            <td>
                                <code class="small text-secondary">{{ $category->slug }}</code>
                            </td>

                            {{-- Type --}}
                            <td>
                                @if($category->is_parent)
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">Parent</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Sub</span>
                                @endif
                            </td>

                            {{-- Parent --}}
                            <td>
                                @if($category->parent_id && $category->parent)
                                    <span class="text-muted small">{{ $category->parent->title }}</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>

                            {{-- Added By --}}
                            <td>
                                @if($category->addedBy)
                                    <span class="small">{{ $category->addedBy->name }}</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>

                            {{-- Status --}}
                            <td class="text-center">
                                @if($category->status === 'active')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3">Active</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3">Inactive</span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="text-center">
                                <a href="{{ route('admin.categories.edit', $category->id) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete {{ $category->title }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-5">
                                <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                                No categories found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection
