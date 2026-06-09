@extends('frontend.layouts.master')

@section('title', $product->title . trans_lang(' - متجرنا', ' - Our Store'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/css/product.css') }}">
@endpush

@section('content')

{{-- Hidden product data for JS --}}
<<div id="productData"
     data-id="{{ $product->id }}"
     data-slug="{{ $product->slug }}"
     data-title="{{ $product->title }}"
     data-price="{{ $product->price }}"
     data-image="{{ $product->images->first() ? asset('uploads/' . $product->images->first()->image) : '' }}"
     style="display:none">
</div>

<div class="pd-wrapper">


    {{-- ════ MAIN GRID ════ --}}
    <div class="pd-grid">

  {{-- ── GALLERY COLUMN ── --}}
<div class="gallery-col">
    <div class="main-img-wrap" id="mainImgWrap">
        <img id="mainImg"
             src="{{ $product->images->first() ? asset('uploads/' . $product->images->first()->image) : 'https://placehold.co/600x600/0e1420/64748b?text=No+Image' }}"
             alt="{{ $product->title }}"
             onerror="this.src='https://placehold.co/600x600/0e1420/64748b?text=No+Image'">

        <div class="img-badge-group">
            @if($product->discount)
                <span class="img-badge discount">
                    <i class="fas fa-bolt me-1"></i>{{ $product->discount }}% {{ trans_lang('خصم', 'OFF') }}
                </span>
            @endif
            @if($product->created_at->diffInDays(now()) <= 7)
                <span class="img-badge new">{{ trans_lang('جديد', 'New') }}</span>
            @endif
            @if($product->stock <= 5 && $product->stock > 0)
                <span class="img-badge hot">
                    <i class="fas fa-fire me-1"></i>{{ trans_lang('ينتهي قريباً', 'Almost Gone') }}
                </span>
            @endif
        </div>

        <div class="zoom-hint">
            <i class="fas fa-search-plus"></i> {{ trans_lang('مرر للتكبير', 'Scroll to zoom') }}
        </div>
    </div>

    <div class="thumbnails">
        @foreach($product->images as $img)
            <div class="thumb {{ $loop->first ? 'active' : '' }}"
                 onclick="changeImg(this, '{{ asset('uploads/' . $img->image) }}')">
                <img src="{{ asset('uploads/' . $img->image) }}"
                     onerror="this.src='https://placehold.co/68x68/141c2e/64748b?text=img'">
            </div>
        @endforeach
    </div>
</div>

        {{-- ── INFO COLUMN ── --}}
        <div class="info-col">

            {{-- Meta row --}}
            <div class="meta-row">
                @if($product->cat_info)
                    <span class="cat-tag">
                        <i class="fas fa-tag me-1"></i>{{ $product->cat_info->title }}
                    </span>
                @endif
                @if($product->stock > 10)
                    <span class="stock-tag in">
                        <i class="fas fa-circle me-1" style="font-size:.5rem;"></i>{{ trans_lang('متوفر في المخزون', 'In Stock') }}
                    </span>
                @elseif($product->stock > 0)
                    <span class="stock-tag low">
                        <i class="fas fa-circle me-1" style="font-size:.5rem;"></i>
                        {{ trans_lang('تبقى', 'Only') }} {{ $product->stock }} {{ trans_lang('قطع فقط', 'left') }}
                    </span>
                @else
                    <span class="stock-tag out">
                        <i class="fas fa-circle me-1" style="font-size:.5rem;"></i>{{ trans_lang('نفذت الكمية', 'Out of Stock') }}
                    </span>
                @endif
                <span style="font-size:.75rem; color:var(--muted);">
                    {{ trans_lang('كود', 'SKU') }}: #{{ str_pad($product->id, 5, '0', STR_PAD_LEFT) }}
                </span>
            </div>

            {{-- Title --}}
            <h1 class="pd-title">{{ $product->title }}</h1>

            {{-- Rating --}}
            <div class="rating-row">
                <div class="stars-wrap">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <span class="rating-num">4.5</span>
                <span class="reviews-count" onclick="openTab('reviews')">(127 {{ trans_lang('تقييم', 'Reviews') }})</span>
                <span class="sold-badge"><i class="fas fa-fire me-1 text-warning"></i>+850 {{ trans_lang('مبيع', 'Sold') }}</span>
            </div>

            <div class="pd-divider"></div>

            {{-- Price Block --}}
            @php
                $finalPrice = $product->discount
                    ? $product->price - ($product->price * $product->discount / 100)
                    : $product->price;
            @endphp

            <div class="price-block">
                <div class="price-final">
                    <small>{{ trans_lang('جنيه', 'EGP') }}</small>{{ number_format($finalPrice, 2) }}
                </div>
                @if($product->discount)
                    <div class="price-original">
                        {{ trans_lang('السعر الأصلي', 'Original Price') }}: {{ number_format($product->price, 2) }} {{ trans_lang('جنيه', 'EGP') }}
                    </div>
                    <div class="price-saving">
                        <i class="fas fa-scissors"></i>
                        {{ trans_lang('توفير', 'Save') }} {{ number_format($product->price - $finalPrice, 2) }} {{ trans_lang('جنيه', 'EGP') }} ({{ $product->discount }}%)
                    </div>
                @endif
            </div>

            {{-- Stock Counter --}}
            @if($product->stock > 0 && $product->stock <= 5)
                <div class="stock-counter">
                    <i class="fas fa-clock"></i>
                    {{ trans_lang('تبقى', 'Only') }} {{ $product->stock }} {{ trans_lang('قطع فقط — احصل عليه قبل انتهاء الكمية!', 'left — get it before it\'s gone!') }}
                </div>
            @endif

            {{-- Quantity --}}
            <div class="qty-section">
                <div class="qty-label">{{ trans_lang('الكمية', 'Quantity') }}</div>
                <div class="qty-ctrl">
                    <button class="qty-btn" onclick="changeQty(-1)"><i class="fas fa-minus"></i></button>
                    <input class="qty-num" type="number" id="qtyInput" value="1" min="1" max="{{ min(99, $product->stock) }}">
                    <button class="qty-btn" onclick="changeQty(1)"><i class="fas fa-plus"></i></button>
                </div>
            </div>

            {{-- CTA Buttons --}}
            <div class="cta-group">
            <form action="{{ route('add-to-cart') }}" method="POST">
    @csrf
    <input type="hidden" name="slug" value="{{ $product->slug }}">
    <button type="submit" class="btn-cart">
        <i class="fas fa-shopping-cart"></i>
        {{ trans_lang('أضف للسلة', 'Add to Cart') }}
    </button>
</form>
             <form action="{{ route('buy-now') }}" method="POST">
        @csrf
        <input type="hidden" name="slug" value="{{ $product->slug }}">
        <input type="hidden" name="qty" value="1" id="buyQty">
        <button type="submit" class="btn-buy">
            <i class="fas fa-bolt"></i>
            {{ trans_lang('اشتري الآن', 'Buy Now') }}
        </button>
    </form>

            </div>

            {{-- Guarantees --}}
            <div class="guarantee-row">
                <div class="g-item"><i class="fas fa-shield-alt text-info"></i><span>{{ trans_lang('ضمان الجودة', 'Quality Guarantee') }}</span></div>
                <div class="g-item"><i class="fas fa-truck text-success"></i><span>{{ trans_lang('شحن سريع', 'Fast Shipping') }}</span></div>
                <div class="g-item"><i class="fas fa-undo text-warning"></i><span>{{ trans_lang('إرجاع 14 يوم', '14-Day Return') }}</span></div>
                <div class="g-item"><i class="fas fa-lock" style="color:var(--accent)"></i><span>{{ trans_lang('دفع آمن', 'Secure Payment') }}</span></div>
                <div class="g-item"><i class="fas fa-headset" style="color:#a78bfa;"></i><span>{{ trans_lang('دعم 24/7', '24/7 Support') }}</span></div>
                <div class="g-item"><i class="fas fa-certificate" style="color:var(--gold);"></i><span>{{ trans_lang('منتج أصلي', 'Original Product') }}</span></div>
            </div>

            <div class="pd-divider"></div>

            {{-- Share --}}
            <div class="share-row">
                <span class="share-lbl"><i class="fas fa-share-alt me-1"></i>{{ trans_lang('شارك', 'Share') }}:</span>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="share-btn fb"><i class="fab fa-facebook-f"></i></a>
                <a href="https://wa.me/?text={{ urlencode($product->title . ' - ' . url()->current()) }}" target="_blank" class="share-btn wa"><i class="fab fa-whatsapp"></i></a>
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($product->title) }}" target="_blank" class="share-btn tw"><i class="fab fa-x-twitter"></i></a>
                <button class="share-btn" onclick="copyLink()" title="{{ trans_lang('نسخ الرابط', 'Copy Link') }}" id="copyBtn"><i class="fas fa-link"></i></button>
            </div>

        </div>
    </div>

    {{-- ════ TABS SECTION ════ --}}
    <div class="tabs-section">
        <div class="tabs-nav">

            <button class="tab-btn" onclick="openTab('specs', this)">
                <i class="fas fa-list-ul me-2"></i>{{ trans_lang('المواصفات', 'Specifications') }}
            </button>

            <button class="tab-btn" onclick="openTab('shipping', this)">
                <i class="fas fa-truck me-2"></i>{{ trans_lang('الشحن والتوصيل', 'Shipping & Delivery') }}
            </button>
        </div>

        {{-- Description --}}
        <div class="tab-content active" id="tab-desc">
            <p class="desc-text">
                {!! nl2br(e($product->description ?? trans_lang('لا يوجد وصف متاح لهذا المنتج حالياً.', 'No description available for this product.'))) !!}
            </p>
        </div>

        {{-- Specs --}}
        <div class="tab-content" id="tab-specs">
            <table class="specs-table">
                <tbody>
                    <tr><td>{{ trans_lang('الاسم', 'Name') }}</td><td>{{ $product->title }}</td></tr>
                    <tr><td>{{ trans_lang('القسم', 'Category') }}</td><td>{{ $product->cat_info->title ?? trans_lang('غير محدد', 'N/A') }}</td></tr>
                    @if($product->sub_cat_info)
                        <tr><td>{{ trans_lang('القسم الفرعي', 'Subcategory') }}</td><td>{{ $product->sub_cat_info->title }}</td></tr>
                    @endif
                    <tr><td>{{ trans_lang('السعر', 'Price') }}</td><td>{{ number_format($product->price, 2) }} {{ trans_lang('جنيه', 'EGP') }}</td></tr>
                    @if($product->discount)
                        <tr><td>{{ trans_lang('الخصم', 'Discount') }}</td><td>{{ $product->discount }}%</td></tr>
                        <tr><td>{{ trans_lang('السعر بعد الخصم', 'Price After Discount') }}</td><td style="color:var(--green); font-weight:700;">{{ number_format($finalPrice, 2) }} {{ trans_lang('جنيه', 'EGP') }}</td></tr>
                    @endif
                    <tr><td>{{ trans_lang('الحالة', 'Status') }}</td><td><span style="color:var(--green);">✓ {{ trans_lang('متوفر', 'Available') }}</span></td></tr>
                    <tr><td>{{ trans_lang('كود المنتج', 'SKU') }}</td><td>#{{ str_pad($product->id, 5, '0', STR_PAD_LEFT) }}</td></tr>
                </tbody>
            </table>
        </div>


        {{-- Shipping --}}
        <div class="tab-content" id="tab-shipping">
            <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:1rem;">
                @foreach([
                    ['fas fa-shipping-fast','text-info', trans_lang('توصيل سريع','Fast Delivery'), trans_lang('خلال 24-48 ساعة في القاهرة والجيزة','Within 24-48 hours in Cairo & Giza')],
                    ['fas fa-map-marker-alt','text-success', trans_lang('التغطية الجغرافية','Coverage'), trans_lang('جميع محافظات مصر','All Egyptian Governorates')],
                    ['fas fa-hand-holding-usd','text-warning', trans_lang('الدفع عند الاستلام','Cash on Delivery'), trans_lang('متاح في معظم المناطق','Available in most areas')],
                    ['fas fa-undo','text-danger', trans_lang('سياسة الإرجاع','Return Policy'), trans_lang('خلال 14 يوم من الاستلام','Within 14 days of receipt')],
                ] as [$icon, $color, $title, $desc])
                    <div style="background:var(--surface2); border:1px solid var(--border); border-radius:10px; padding:1.1rem;">
                        <i class="{{ $icon }} {{ $color }} mb-2" style="font-size:1.4rem; display:block;"></i>
                        <div style="font-weight:700; color:var(--text); font-size:.9rem; margin-bottom:.3rem;">{{ $title }}</div>
                        <div style="font-size:.82rem; color:var(--muted);">{{ $desc }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ════ RELATED PRODUCTS ════ --}}
    @if(isset($related) && $related->count())
        <div class="related-section">
            <div class="sec-title">{{ trans_lang('منتجات مشابهة', 'Related Products') }}</div>
            <div class="row g-3">
                @foreach($related->take(4) as $rel)
                    <div class="col-xl-3 col-lg-3 col-sm-6">
                        <a href="{{ route('product.show_details', $rel->slug) }}" class="rel-card">
                            <div class="rel-img">
                                <img src="{{ $rel->images->first() ? asset('uploads/' . $rel->images->first()->image) : 'https://placehold.co/300x150/141c2e/64748b?text=Product' }}"                                     alt="{{ $rel->title }}"
                                     onerror="this.src='https://placehold.co/300x150/141c2e/64748b?text={{ trans_lang('منتج', 'Product') }}'">
                            </div>
                            <div class="rel-body">
                                <div class="rel-title">{{ $rel->title }}</div>
                                <div class="rel-price">
                                    {{ number_format($rel->discount ? $rel->price - ($rel->price * $rel->discount / 100) : $rel->price, 0) }}
                                    <small style="font-size:.72rem;">{{ trans_lang('جنيه', 'EGP') }}</small>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif




@endsection

@push('scripts')
    <script src="{{ asset('frontend/js/product.js') }}"></script>
@endpush
