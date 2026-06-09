@extends('frontend.layouts.master')

@section('title', trans_lang('نتائج البحث: ' . $keyword, 'Search Results: ' . $keyword))

@push('styles')
    <style>
        /* ════════════════════════════════
           SEARCH RESULTS PAGE
           ════════════════════════════════ */
        .search-header {
            background: linear-gradient(135deg, #1a56db 0%, #1e429f 100%);
            color: #fff;
            padding: 3rem 0;
            text-align: center;
            margin-bottom: 2rem;
        }
        .search-header h1 {
            font-weight: 800;
            font-size: 1.8rem;
            margin-bottom: .5rem;
        }
        .search-header p {
            opacity: .9;
            font-size: 1rem;
            margin: 0;
        }
        .search-header .keyword {
            background: rgba(255,255,255,.2);
            padding: .2rem .6rem;
            border-radius: 6px;
            font-weight: 700;
        }

        .search-form-box {
            max-width: 600px;
            margin: -1.5rem auto 2rem;
            position: relative;
            z-index: 10;
        }
        .search-form-box form {
            display: flex;
            gap: .5rem;
            background: #fff;
            padding: .5rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,.1);
        }
        .search-form-box input {
            flex: 1;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: .75rem 1rem;
            font-size: 1rem;
            font-family: 'Cairo', sans-serif;
        }
        .search-form-box input:focus {
            border-color: #1a56db;
            outline: none;
        }
        .search-form-box button {
            background: #1a56db;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: .75rem 1.5rem;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s;
        }
        .search-form-box button:hover {
            background: #1e429f;
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
        .product-image {
            position: relative;
            padding-top: 75%;
            overflow: hidden;
            background: #f9fafb;
        }
        .product-image img {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            object-fit: cover;
            transition: transform .3s;
        }
        .product-card:hover .product-image img {
            transform: scale(1.05);
        }
        .product-badge {
            position: absolute;
            top: .75rem;
            left: .75rem;
            background: #059669;
            color: #fff;
            padding: .25rem .6rem;
            border-radius: 6px;
            font-size: .75rem;
            font-weight: 700;
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

        .empty-search {
            text-align: center;
            padding: 4rem 2rem;
        }
        .empty-search i {
            font-size: 4rem;
            color: #d1d5db;
            margin-bottom: 1rem;
        }
        .empty-search h3 {
            font-weight: 700;
            color: #1f2937;
            margin-bottom: .5rem;
        }
        .empty-search p {
            color: #6b7280;
            margin-bottom: 1.5rem;
        }
        .empty-search .btn-browse {
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
        .pagination .page-link svg {
    width: 10px !important;
    height: 10px !important;
}

.pagination .page-link {
    padding: .35rem .6rem;
    line-height: 1;
}
.pagination .page-link svg {
    width: 8px !important;
    height: 8px !important;
}
    </style>

@endpush

@section('content')

        {{-- ════════ RESULTS COUNT ════════ --}}
        <div class="results-count">
            {{ trans_lang('تم العثور على', 'Found') }}
            <strong>{{ $products->total() }}</strong>
            {{ trans_lang('منتج', 'product') }}{{ $products->total() != 1 ? trans_lang('ات', 's') : '' }}
        </div>

        {{-- ════════ PRODUCTS GRID ════════ --}}
        @if($products->count() > 0)
            <div class="row g-4">
                @foreach($products as $product)
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="product-card">

                {{-- Image --}}
               <div class="prod-img-wrap">
    @php $firstImage = $product->images->first(); @endphp
    <img src="{{ $firstImage ? asset('uploads/' . $firstImage->image) : asset('images/no-image.png') }}"
         alt="{{ $product->title }}"
         loading="lazy"
         onerror="this.src='https://placehold.co/400x300/0e1420/64748b?text=No+Image'">

                            </div>
                            <div class="product-body">
                                <h5 class="product-title">
                                    <a href="{{ route('product.show_details', $product->slug) }}">
                                        {{ $product->title }}
                                    </a>
                                </h5>
                                <p class="product-summary">
                                    {{ Str::limit($product->summary, 80) }}
                                </p>
                                <div class="product-footer">
                                    <div class="product-price">
                                        {{ number_format($product->price_after_discount ?? $product->price, 0) }}
                                        {{ trans_lang('جنيه', 'EGP') }}
                                        @if($product->discount > 0)
                                            <span class="old-price">
                                                {{ number_format($product->price, 0) }}
                                            </span>
                                        @endif
                                    </div>
                                    <a href="{{ route('product.show_details', $product->slug) }}" class="btn-view">
                                        {{ trans_lang('عرض', 'View') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- ════════ PAGINATION ════════ --}}
            <div class="pagination-wrapper">
                {{ $products->appends(['q' => $keyword])->links() }}
            </div>

        @else
            {{-- ════════ EMPTY STATE ════════ --}}
            <div class="empty-search">
                <i class="fas fa-search"></i>
                <h3>{{ trans_lang('لا توجد نتائج', 'No Results Found') }}</h3>
                <p>
                    {{ trans_lang('لم نجد أي منتجات تطابق بحثك. جرب كلمات مختلفة.',
                                  'We could not find any products matching your search. Try different keywords.') }}
                </p>
                <a href="{{ route('products.home') }}" class="btn-browse">
                    <i class="fas fa-th-large me-2"></i>
                    {{ trans_lang('تصفح كل المنتجات', 'Browse All Products') }}
                </a>
            </div>
        @endif

    </div>

@endsection
