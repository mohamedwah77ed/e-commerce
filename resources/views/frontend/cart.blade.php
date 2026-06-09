@extends('frontend.layouts.master')

@section('title', trans_lang('سلة المشتريات - متجرنا', 'Shopping Cart - Our Store'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/css/cart.css') }}">
@endpush

@section('content')
<div class="cart-page">

    {{-- ════════ PAGE HEADER ════════ --}}
    <div class="cart-header">
        <h1 class="cart-title">
            <i class="fas fa-shopping-cart"></i>
            {{ trans_lang('سلة المشتريات', 'Shopping Cart') }}
        </h1>
        <span class="cart-count">
            <span class="count-badge">{{ $cartCount ?? 0 }}</span>
            {{ trans_lang('منتج', 'Items') }}
        </span>
    </div>

    @if(isset($products) && $products->count() > 0)

        <div class="row g-4">

            {{-- ════════ CART ITEMS ════════ --}}
            <div class="col-lg-8">
                <div class="cart-items-card">
                    <div class="card-head">
                        <span><i class="fas fa-box-open me-2"></i>{{ trans_lang('المنتجات', 'Products') }}</span>
                        <span class="items-count">{{ $products->count() }} {{ trans_lang('صنف', 'Items') }}</span>
                    </div>

                    <div class="cart-items-list">
                        @foreach($products as $item)
                        <div class="cart-item">
                            {{-- Product Image --}}
                            <div class="item-img">
                                <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : asset('images/no-image.png') }}"
                                     alt="{{ $item->product->title }}"
                                     onerror="this.src='https://placehold.co/120x120/141c2e/64748b?text={{ trans_lang('لا+صورة', 'No+Image') }}'">
                            </div>

                            {{-- Product Info --}}
                            <div class="item-info">
                                <h5 class="item-title">{{ $item->product->title }}</h5>
                                <div class="item-meta">
                                    <span class="item-price">
                                        {{ number_format($item->price, 0) }} {{ trans_lang('جنيه', 'EGP') }}
                                    </span>
                                    @if($item->product->stock > 0)
                                        <span class="stock-badge in-stock">
                                            <i class="fas fa-check-circle"></i> {{ trans_lang('متوفر', 'In Stock') }}
                                        </span>
                                    @else
                                        <span class="stock-badge out-stock">
                                            <i class="fas fa-times-circle"></i> {{ trans_lang('نفذت الكمية', 'Out of Stock') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Quantity Controls --}}
                            <div class="item-qty">
                                <form action="{{ route('cart.decrease') }}" method="POST" class="qty-form">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                    <button type="submit" class="qty-btn minus" {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </form>

                                <span class="qty-value">{{ $item->quantity }}</span>

                                <form action="{{ route('cart.increase') }}" method="POST" class="qty-form">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                    <button type="submit" class="qty-btn plus">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </form>
                            </div>

                            {{-- Item Total --}}
                            <div class="item-total">
                                <span class="total-label">{{ trans_lang('الإجمالي', 'Total') }}</span>
                                <span class="total-value">{{ number_format($item->amount, 0) }} {{ trans_lang('جنيه', 'EGP') }}</span>
                            </div>

                            {{-- Remove Button --}}
                            <form action="{{ route('cart-delete') }}" method="POST" class="remove-form">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{ $item->id }}">
                                <button type="submit" class="remove-btn"
                                        title="{{ trans_lang('حذف من السلة', 'Remove from Cart') }}"
                                        onclick="return confirm('{{ trans_lang('هل أنت متأكد من حذف هذا المنتج؟', 'Are you sure you want to remove this item?') }}')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- ════════ ORDER SUMMARY ════════ --}}
            <div class="col-lg-4">
                <div class="summary-card">
                    <div class="summary-head">
                        <i class="fas fa-receipt me-2"></i>
                        {{ trans_lang('ملخص الطلب', 'Order Summary') }}
                    </div>

                    <div class="summary-body">
                        <div class="summary-row">
                            <span>{{ trans_lang('عدد المنتجات', 'Items Count') }}</span>
                            <span class="value">{{ $cartCount ?? 0 }}</span>
                        </div>

                        <div class="summary-row">
                            <span>{{ trans_lang('سعر المنتجات', 'Subtotal') }}</span>
                            <span class="value">{{ number_format($cartTotal ?? $products->sum('amount'), 0) }} {{ trans_lang('جنيه', 'EGP') }}</span>
                        </div>

                        <div class="summary-row">
                            <span>{{ trans_lang('الشحن', 'Shipping') }}</span>
                            <span class="value free">{{ trans_lang('مجاني', 'Free') }}</span>
                        </div>

                        <div class="summary-divider"></div>

                        <div class="summary-row total">
                            <span>{{ trans_lang('الإجمالي الكلي', 'Grand Total') }}</span>
                            <span class="value">{{ number_format($cartTotal ?? $products->sum('amount'), 0) }} {{ trans_lang('جنيه', 'EGP') }}</span>
                        </div>

                        {{-- Checkout Button --}}
                        <a href="{{ route('checkout') }}" class="btn-checkout">
                            <i class="fas fa-credit-card"></i>
                            {{ trans_lang('إتمام عملية الشراء', 'Proceed to Checkout') }}
                        </a>

                        {{-- Continue Shopping --}}
                        <a href="/" class="btn-continue">
                            <i class="fas fa-arrow-{{ trans_lang('right', 'left') }}"></i>
                            {{ trans_lang('متابعة التسوق', 'Continue Shopping') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

    @else

        {{-- ════════ EMPTY CART ════════ --}}
        <div class="empty-cart">
            <div class="empty-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <h3>{{ trans_lang('سلة المشتريات فارغة', 'Your Cart is Empty') }}</h3>
            <p>{{ trans_lang('لم تقم بإضافة أي منتجات للسلة بعد. استكشف منتجاتنا وابدأ التسوق!', 'You have not added any products yet. Explore our products and start shopping!') }}</p>
            <a href="{{ route('products.home') }}" class="btn-shop">
                <i class="fas fa-store"></i>
                {{ trans_lang('تسوق الآن', 'Shop Now') }}
            </a>
        </div>

    @endif

</div>
@endsection
