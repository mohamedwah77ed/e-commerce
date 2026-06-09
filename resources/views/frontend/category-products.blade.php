@extends('frontend.layouts.master')

@push('styles')
    <style>
        .brand-header {
            background: linear-gradient(135deg, #1a56db 0%, #1e429f 100%);
            color: #fff;
            padding: 3rem 0;
            text-align: center;
            margin-bottom: 2rem;
        }
        .brand-header h1 {
            font-weight: 800;
            font-size: 1.8rem;
            margin-bottom: .5rem;
        }
        .brand-header p {
            opacity: .9;
            font-size: 1rem;
            margin: 0;
        }
        .brand-header .brand-name {
            background: rgba(255,255,255,.2);
            padding: .2rem .6rem;
            border-radius: 6px;
            font-weight: 700;
        }

        .results-count {
            color: #6b7280;
            font-size: .9rem;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }
        .results-count strong {
            color: #1f2937;
        }
        .product-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,.08);
            border: 1px solid #e5e7eb;
            overflow: hidden;
            transition: all .3s;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 40px rgba(0,0,0,.1);
        }
        .prod-img-wrap {
            position: relative;
            padding-top: 75%;
            overflow: hidden;
            background: #f9fafb;
        }
        .prod-img-wrap img {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            object-fit: cover;
            transition: transform .3s;
        }
        .product-card:hover .prod-img-wrap img {
            transform: scale(1.05);
        }
        .product-body {
            padding: 1.25rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .product-title {
            font-weight: 700;
            font-size: 1rem;
            color: #1f2937;
            margin-bottom: .5rem;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .product-title a {
            color: inherit;
            text-decoration: none;
        }
        .product-title a:hover {
            color: #1a56db;
        }
        .product-summary {
            color: #6b7280;
            font-size: .85rem;
            line-height: 1.6;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            flex: 1;
        }
        .product-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
        }
        .product-price {
            font-weight: 900;
            font-size: 1.15rem;
            color: #1a56db;
        }
        .product-price .old-price {
            font-size: .85rem;
            color: #9ca3af;
            text-decoration: line-through;
            font-weight: 600;
            margin-{{ is_rtl() ? 'right' : 'left' }}: .5rem;
        }
        .btn-view {
            background: #1a56db;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: .5rem 1rem;
            font-size: .85rem;
            font-weight: 700;
            text-decoration: none;
            transition: all .2s;
        }
        .btn-view:hover {
            background: #1e429f;
            color: #fff;
        }
        .empty-brand {
            text-align: center;
            padding: 4rem 2rem;
        }
        .empty-brand i {
            font-size: 4rem;
            color: #d1d5db;
            margin-bottom: 1rem;
        }
        .empty-brand h3 {
            font-weight: 700;
            color: #1f2937;
            margin-bottom: .5rem;
        }
        .empty-brand p {
            color: #6b7280;
            margin-bottom: 1.5rem;
        }
        .empty-brand .btn-browse {
            background: #1a56db;
            color: #fff;
            padding: .75rem 2rem;
            border-radius: 10px;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
        }
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
        }
        .pagination .page-link {
            border: 2px solid #e5e7eb;
            color: #1f2937;
            font-weight: 700;
            padding: .5rem .9rem;
            margin: 0 .2rem;
            border-radius: 8px;
        }
        .pagination .page-link:hover {
            background: #1a56db;
            border-color: #1a56db;
            color: #fff;
        }
        .pagination .active .page-link {
            background: #1a56db;
            border-color: #1a56db;
            color: #fff;
        }
    </style>
@endpush

@section('content')
    <div class="brand-header">
        <div class="container">
            <h1>
                <i class="fas fa-tag me-2"></i>
                {{ trans_lang('منتجات', 'Products of') }}
                <span class="brand-name">{{ $category->title }}</span>
            </h1>
            <p>{{ trans_lang('تصفح جميع المنتجات في هذه الفئة', 'Browse all products in this category') }}</p>
        </div>
    </div>

    <div class="container">
        <div class="results-count">
            {{ trans_lang('تم العثور على', 'Found') }}
            <strong>{{ $products->total() }}</strong>
            {{ trans_lang('منتج', 'product') }}
        </div>

        @forelse ($products as $product)
            @if ($loop->first)
                <div class="row g-4">
            @endif

            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="product-card">
                    <div class="prod-img-wrap">
                        @php $firstImage = $product->images->first(); @endphp
                        <img src="{{ $firstImage ? asset('uploads/' . $firstImage->image) : asset('images/no-image.png') }}"
                             alt="{{ $product->title }}"
                             loading="lazy"
                             onerror="this.src='https://placehold.co/400x300/0e1420/64748b?text=No+Image'">
                    </div>
                    <div class="product-body">
                        <h3 class="product-title">
                            <a href="{{ route('product.show_details', $product->slug) }}">
                                {{ $product->title }}
                            </a>
                        </h3>

                        @if($product->summary)
                            <p class="product-summary">{{ $product->summary }}</p>
                        @endif

                        <div class="product-footer">
                            <div class="product-price">
                                {{ number_format($product->price, 2) }}
                                @if(isset($product->old_price) && $product->old_price > 0)
                                    <span class="old-price">{{ number_format($product->old_price, 2) }}</span>
                                @endif
                            </div>
                            <a href="{{ route('product.show_details', $product->slug) }}" class="btn-view">
                                {{ trans_lang('عرض', 'View') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            @if ($loop->last)
                </div>
            @endif
        @empty
            <div class="empty-brand">
                <i class="fas fa-box-open"></i>
                <h3>{{ trans_lang('لا توجد منتجات', 'No Products Found') }}</h3>
                <p>{{ trans_lang('لا توجد منتجات متاحة لهذه الفئة حالياً', 'No products available for this category yet') }}</p>
                <a href="{{ url('/') }}" class="btn-browse">
                    {{ trans_lang('تصفح المنتجات', 'Browse Products') }}
                </a>
            </div>
        @endforelse

        @if($products->hasPages())
            <div class="pagination-wrapper">
                {{ $products->links() }}
            </div>
        @endif
    </div>
@endsection
