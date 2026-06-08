@extends('backend.layouts.master')

@section('title', $product->title)

@section('content')
<style>
    .thumb:hover {
        opacity: 1 !important;
        border-color: #64748b !important;
    }

    .thumb.active {
        opacity: 1 !important;
        border-color: #0d6efd !important;
        box-shadow: 0 0 0 2px rgba(13, 110, 253, 0.2);
    }

    .thumbnails::-webkit-scrollbar {
        height: 4px;
    }

    .thumbnails::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .thumbnails::-webkit-scrollbar-thumb {
        background: #64748b;
        border-radius: 4px;
    }
</style>
<div class="container py-4">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
            <li class="breadcrumb-item active">{{ $product->title }}</li>
        </ol>
    </nav>

    <div class="row g-4">

        <!-- الصور -->
<div class="col-lg-5">
    <div class="card border-0 shadow-sm">
        <div class="card-body p-3">

            <!-- الصورة الرئيسية -->
            <div class="main-image-container mb-3 position-relative" style="height: 400px; background: #f8f9fa; border-radius: 12px; overflow: hidden;">
                @php
                    $mainImg = $product->image ?? ($product->images->first()->image ?? null);
                @endphp

                @if($mainImg)
                    <img src="{{ asset('uploads/' . $mainImg) }}"
                         class="w-100 h-100 position-absolute top-0 start-0"
                         style="object-fit: contain; padding: 20px;"
                         alt="{{ $product->title }}"
                         id="mainImage"
                         onerror="this.src='https://placehold.co/600x400/141c2e/64748b?text=No+Image'">
                @else
                    <div class="d-flex align-items-center justify-content-center h-100">
                        <span class="text-muted">No Image Available</span>
                    </div>
                @endif
            </div>

            <!-- Thumbnails -->
            @if($product->images && $product->images->count() > 0)
                <div class="thumbnails d-flex gap-2 overflow-auto pb-1" style="scrollbar-width: thin;">
                    @foreach($product->images as $img)
                        <div class="thumb {{ $loop->first ? 'active' : '' }}"
                             onclick="changeImg(this, '{{ asset('uploads/' . $img->image) }}')"
                             style="min-width: 68px; width: 68px; height: 68px; border-radius: 8px; overflow: hidden; cursor: pointer; border: 2px solid transparent; transition: all 0.2s; opacity: 0.6;">

                            <img src="{{ asset('uploads/' . $img->image) }}"
                                 style="width: 100%; height: 100%; object-fit: cover;"
                                 onerror="this.src='https://placehold.co/68x68/141c2e/64748b?text={{ $loop->iteration }}'">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

        <!-- التفاصيل -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    <!-- العنوان والحالة -->
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h3 class="mb-0">{{ $product->title }}</h3>
                        <div>
                            @if($product->status === 'active')
                                <span class="badge bg-success fs-6">Active</span>
                            @else
                                <span class="badge bg-secondary fs-6">Inactive</span>
                            @endif

                            @if($product->is_featured)
                                <span class="badge bg-warning text-dark fs-6 ms-1">⭐ Featured</span>
                            @endif
                        </div>
                    </div>

                    <!-- السعر -->
                    <div class="mb-3">
                        <h4 class="text-primary mb-0">
                            ${{ number_format($product->price, 2) }}
                            @if($product->discount > 0)
                                <small class="text-muted text-decoration-line-through ms-2">
                                    ${{ number_format($product->price + $product->discount, 2) }}
                                </small>
                                <span class="badge bg-danger ms-2">-{{ round(($product->discount / ($product->price + $product->discount)) * 100) }}%</span>
                            @endif
                        </h4>
                    </div>

                    <!-- معلومات سريعة -->
                    <div class="row g-3 mb-4">
                        <div class="col-6 col-md-4">
                            <div class="p-2 bg-light rounded">
                                <small class="text-muted d-block">Category</small>
                                <strong>{{ $product->cat_info->title ?? '—' }}</strong>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="p-2 bg-light rounded">
                                <small class="text-muted d-block">Sub Category</small>
                                <strong>{{ $product->sub_cat_info->title ?? '—' }}</strong>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="p-2 bg-light rounded">
                                <small class="text-muted d-block">Brand</small>
                                <strong>{{ $product->brand->title ?? '—' }}</strong>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="p-2 bg-light rounded">
                                <small class="text-muted d-block">Stock</small>
                                <strong class="{{ $product->stock > 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $product->stock > 0 ? $product->stock . ' units' : 'Out of Stock' }}
                                </strong>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="p-2 bg-light rounded">
                                <small class="text-muted d-block">Condition</small>
                                <strong>{{ ucfirst($product->condition ?? 'New') }}</strong>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="p-2 bg-light rounded">
                                <small class="text-muted d-block">Size</small>
                                <strong>{{ $product->size ?? '—' }}</strong>
                            </div>
                        </div>
                    </div>

                    <!-- الوصف -->
                    <div class="mb-4">
                        <h5>Summary</h5>
                        <p class="text-muted">{{ $product->summary ?? 'No summary available.' }}</p>
                    </div>

                    <div class="mb-4">
                        <h5>Description</h5>
                        <div class="text-muted">{!! $product->description ?? 'No description available.' !!}</div>
                    </div>

                    <!-- الأزرار -->
                    <div class="d-flex gap-2 pt-3 border-top">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Delete this product?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
<script>
function changeImg(element, src) {
    // غير الصورة الرئيسية
    document.getElementById('mainImage').src = src;

    // شيل الـ active من كل الـ thumbnails
    document.querySelectorAll('.thumb').forEach(thumb => {
        thumb.classList.remove('active');
    });

    // حط الـ active على اللي اتكلكت
    element.classList.add('active');
}
</script>

@endsection
