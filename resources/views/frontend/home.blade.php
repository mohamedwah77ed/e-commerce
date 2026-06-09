@extends('frontend.layouts.master')

@section('title', trans_lang('الرئيسية - متجرنا', 'Home - Our Store'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/css/home.css') }}">

@endpush

@section('content')

{{-- ═══════════════════════════════════════
     1. HERO CAROUSEL (Top Banner)
   ═══════════════════════════════════════ --}}
<div class="dp-hero-carousel" id="heroCarousel">
    @php
        $heroSlides = [
            [
                'desk' => 'https://assets-dubaiphone.dubaiphone.net/dp-prod/wp-content/uploads/2026/06/seven-apple-ar-web-copy.webp',
                'mob'  => 'https://assets-dubaiphone.dubaiphone.net/dp-prod/wp-content/uploads/2026/06/seven-apple-ar-mob-copy.webp',
                'link' => '/brand/apple',
                'alt'  => 'Apple'

            ],


        ];
    @endphp

    @foreach($heroSlides as $i => $slide)
        <div class="dp-hero-slide {{ $i === 0 ? 'active' : '' }}">
            <a href="{{ url($slide['link']) }}">
                <img src="{{ $slide['desk'] }}" alt="{{ $slide['alt'] }}" class="hero-desk" loading="{{ $i === 0 ? 'eager' : 'lazy' }}">
                <img src="{{ $slide['mob'] }}" alt="{{ $slide['alt'] }}" class="hero-mobile" loading="{{ $i === 0 ? 'eager' : 'lazy' }}">
            </a>
        </div>
    @endforeach
</div>

{{-- Carousel Dots --}}
<div class="dp-carousel-dots">
    @foreach($heroSlides as $i => $slide)
        <button class="dp-dot {{ $i === 0 ? 'active' : '' }}" onclick="goToHeroSlide({{ $i }})" aria-label="Slide {{ $i + 1 }}"></button>
    @endforeach
</div>

{{-- ═══════════════════════════════════════
     2. TRUST BADGES (Apple Reseller, Warranty, Delivery)
   ═══════════════════════════════════════ --}}
<div class="dp-trust-bar">
    <div class="row g-3 text-center">
        <div class="col-4 dp-trust-item">
            <i class="fas fa-shield-alt"></i>
            <span>{{ trans_lang('ضمان معتمد', 'Authorized Warranty') }}</span>
        </div>
        <div class="col-4 dp-trust-item">
            <i class="fas fa-truck-fast"></i>
            <span>{{ trans_lang('شحن سريع', 'Fast Delivery') }}</span>
        </div>
        <div class="col-4 dp-trust-item">
            <i class="fas fa-rotate-left"></i>
            <span>{{ trans_lang('استبدال سهل', 'Easy Exchange') }}</span>
        </div>
    </div>
</div>
{{-- 3. SHOP BY CATEGORY --}}
<section class="nf-hero-categories" aria-labelledby="nf-hero-cat-heading">
    <h2 id="nf-hero-cat-heading" class="nf-section-h2">
        {{ trans_lang('تسوق بالفئة', 'Shop by Category') }}
    </h2>
    <div class="nf-hero-categories__track">
        @php
            $categoryIcons = [
                'phone'           => 'fa-mobile-screen',
                'laptops'         => 'fa-laptop',
                'tablets'         => 'fa-tablet-screen-button',
                'headphones'      => 'fa-headphones',
                'smart-watches'   => 'fa-clock',
                'gaming'          => 'fa-gamepad',
                'home-appliances' => 'fa-house-laptop',
                'accessories'     => 'fa-plug',
                // Sub-categories
                'iphone'          => 'fa-apple-whole',
                'samsung-galaxy'  => 'fa-mobile',
                'gaming-laptops'  => 'fa-dice',
                'work-laptops'    => 'fa-briefcase',
            ];
        @endphp

        @forelse($categories as $cat)
            <div class="nf-hero-cat-cell">
                <a href="{{ route('category.products', $cat->slug) }}" class="nf-hero-cat-link">
                    <div class="cat-icon">
                        <i class="fas {{ $categoryIcons[$cat->slug] ?? 'fa-tag' }}"></i>
                    </div>
                    <span>{{ $cat->title }}</span>
                </a>
            </div>
        @empty
            <p class="text-muted">لا توجد تصنيفات متاحة</p>
        @endforelse
    </div>
</section>
{{-- ═══════════════════════════════════════
     4. BEST SELLERS (Tabs + AJAX Product Carousel)
   ═══════════════════════════════════════ --}}
<section class="nf-product-section" data-section="best-sellers">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="nf-section-h2">{{ trans_lang('الأكثر مبيعًا', 'Best Sellers') }}</h2>
        <a href="{{ url('/shop') }}" class="nf-view-all">
            {{ trans_lang('عرض الكل', 'View All') }}
            <i class="fas fa-chevron-left" style="font-size:.7rem;"></i>
        </a>
    </div>

    {{-- التابس مع أيقونات --}}
    <div class="nf-tabs-scroll" role="tablist">
        <button type="button"
                class="nf-tab nf-tab--active"
                data-tab="mobiles"
                data-slug="phone"
                onclick="switchTab(this, 'phone')">
            <i class="fas fa-mobile-alt"></i>
            <span>{{ trans_lang('الموبايلات', 'Mobiles') }}</span>
        </button>

        <button type="button"
                class="nf-tab"
                data-tab="tablets"
                data-slug="tablets"
                onclick="switchTab(this, 'tablets')">
            <i class="fas fa-tablet-alt"></i>
            <span>{{ trans_lang('التابلت', 'Tablets') }}</span>
        </button>

        <button type="button"
                class="nf-tab"
                data-tab="watches"
                data-slug="smart-watches"
                onclick="switchTab(this, 'smart-watches')">
            <i class="fas fa-clock"></i>
            <span>{{ trans_lang('ساعات ذكية', 'Smart Watches') }}</span>
        </button>

        <button type="button"
                class="nf-tab"
                data-tab="headphones"
                data-slug="headphones"
                onclick="switchTab(this, 'headphones')">
            <i class="fas fa-headphones"></i>
            <span>{{ trans_lang('سماعات', 'Headphones') }}</span>
        </button>

        <button type="button"
                class="nf-tab"
                data-tab="laptops"
                data-slug="laptops"
                onclick="switchTab(this, 'laptops')">
            <i class="fas fa-laptop"></i>
            <span>{{ trans_lang('لابتوبات', 'Laptops') }}</span>
        </button>
    </div>

    {{-- محتوى المنتجات --}}
    <div class="nf-product-carousel" id="bestSellersContent">
        @if($bestSellers->count() > 0)
            @include('frontend.partials.product-carousel', ['products' => $bestSellers])
        @else
            <div class="text-center py-5 text-muted">
                <i class="fas fa-box-open fa-3x mb-3"></i>
                <p>{{ trans_lang('لا توجد منتجات متاحة', 'No products available') }}</p>
            </div>
        @endif
    </div>

    {{-- Loading Spinner (مخفي افتراضياً) --}}
    <div id="bestSellersLoader" class="text-center py-5 d-none">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div class="nf-scroll-progress-wrap">
        <div class="nf-scroll-progress-track">
            <div class="nf-scroll-progress-thumb" id="prodProgress1"></div>
        </div>
    </div>
</section>

{{-- 5. SHOP BY BRAND --}}
<section class="mb-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="nf-section-h2">{{ trans_lang('تسوق بالماركة', 'Shop by Brand') }}</h2>
    </div>
    <div class="nf-brands__track">
        @forelse($brands as $brand)
            <div class="nf-brand-cell">
                <a href="{{ route('brand.products', $brand->slug) }}" class="nf-brand-tile">
                    @if($brand->image)
                        <img src="{{ asset($brand->image) }}" alt="{{ $brand->title }}" loading="lazy">
                    @else
                        <span style="color: {{ $brand->color ?? '#333' }}">{{ $brand->title }}</span>
                    @endif
                </a>
            </div>
        @empty
            <p class="text-muted">لا توجد ماركات متاحة</p>
        @endforelse
    </div>
    {{-- ... progress bar --}}
</section>

{{-- ═══════════════════════════════════════
     6. PROMO BANNER (Trade-in)
   ═══════════════════════════════════════ --}}
<section class="mb-4">
    <a href="{{ url('/trade-in') }}" class="nf-promo-banner">
        <img src="https://uae.dubaidutyfree.com/ccstore/v1/images/?source=/file/general/HD_Apple_Banner.jpg&height=502&width=1850"
             alt="{{ trans_lang('استبدل جهازك القديم', 'Trade in your old device') }}"
             class="hero-desk" loading="lazy">

    </a>
</section>

{{-- 7. APPLE SECTION --}}
<section class="nf-product-section" data-section="apple">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="nf-section-h2">Apple</h2>
        <a href="{{ route('brand.products', 'apple') }}" class="nf-view-all">
            {{ trans_lang('عرض الكل', 'View All') }}
            <i class="fas fa-chevron-left" style="font-size:.7rem;"></i>
        </a>
    </div>

    {{-- ... التابس --}}

    <div class="nf-product-carousel" id="appleContent">
        @if($appleProducts->count() > 0)
            @include('frontend.partials.product-carousel', ['products' => $appleProducts])
        @else
            <p class="text-center text-muted py-4">لا توجد منتجات Apple متاحة</p>
        @endif
    </div>
</section>
{{-- ═══════════════════════════════════════
     9. ASUS PROMO BANNER
   ═══════════════════════════════════════ --}}
<section class="mb-4">
    <a href="/" class="nf-promo-banner">
        <img src="https://assets-dubaiphone.dubaiphone.net/dp-prod/wp-content/uploads/2026/05/asus-des-65-copy.webp"
             alt="Asus Vivobook" class="hero-desk" loading="lazy">
        <img src="https://assets-dubaiphone.dubaiphone.net/dp-prod/wp-content/uploads/2026/05/asus-m-5-copy.webp"
             alt="Asus Vivobook" class="hero-mobile" loading="lazy">
    </a>
</section>
{{-- ═══════════════════════════════════════
     8. LAPTOPS & TABLETS SECTION
   ═══════════════════════════════════════ --}}
<section class="nf-product-section" data-section="laptops">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="nf-section-h2">{{ trans_lang('لابتوبات و التابلت', 'Laptops & Tablets') }}</h2>
    </div>

    <div class="nf-tabs-scroll" role="tablist">
        <button type="button" class="nf-tab nf-tab--active" onclick="switchLaptopTab(this, 'new')">
            {{ trans_lang('وصل حديثاً', 'New Arrivals') }}
        </button>
        <button type="button" class="nf-tab" onclick="switchLaptopTab(this, 'gaming')">
            {{ trans_lang('لابتوب للألعاب', 'Gaming') }}
        </button>
        <button type="button" class="nf-tab" onclick="switchLaptopTab(this, 'work')">
            {{ trans_lang('لابتوب للعمل', 'Work') }}
        </button>
        <button type="button" class="nf-tab" onclick="switchLaptopTab(this, 'tablets')">
            {{ trans_lang('التابلت', 'Tablets') }}
        </button>
    </div>

    <div class="nf-product-carousel" id="laptopContent">
        @include('frontend.partials.product-carousel', ['products' => $laptopProducts ?? []])
    </div>

    <div class="nf-scroll-progress-wrap">
        <div class="nf-scroll-progress-track">
            <div class="nf-scroll-progress-thumb" id="prodProgress3"></div>
        </div>
    </div>
</section>



{{-- ═══════════════════════════════════════
     10. GOAL SECTION (Promo with products)
   ═══════════════════════════════════════ --}}
<section class="nf-product-section mb-4" style="background: linear-gradient(180deg, rgba(0,212,255,.05) 0%, transparent 70%); border-radius: 16px; padding: 1.5rem 1rem;">
    <a href="{{ url('/goal-v2') }}" class="nf-promo-banner mb-3">
        <img src="https://assets-dubaiphone.dubaiphone.net/dp-prod/wp-content/uploads/2026/04/gaol-we-ar-copy-2.webp"
             alt="Goal" class="hero-desk" loading="lazy">
        <img src="https://assets-dubaiphone.dubaiphone.net/dp-prod/wp-content/uploads/2026/04/gaol-mob-ar-copy-2.webp"
             alt="Goal" class="hero-mobile" loading="lazy">
    </a>

    <div class="nf-product-carousel" id="goalContent">
        @include('frontend.partials.product-carousel', ['products' => $goalProducts ?? []])
    </div>

    <div class="nf-scroll-progress-wrap">
        <div class="nf-scroll-progress-track">
            <div class="nf-scroll-progress-thumb" id="prodProgress4"></div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
    <script src="{{ asset('frontend/js/home.js') }}"></script>

@endpush
