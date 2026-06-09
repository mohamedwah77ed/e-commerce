{{-- Product card - Dubai Phone style --}}
@foreach($products as $product)
    @php
        $firstImage = $product->images->first();
        $monthlyPrice = ceil(($product->final_price ?? $product->price) / 24);
    @endphp

    <div class="nf-product-card">

        {{-- صورة المنتج --}}
<div class="nf-product-img-wrap">
    <a href="{{ route('product.show_details', $product->slug) }}"
       class="nf-product-img-link"
       title="{{ $product->title }}">
        <img src="{{ $firstImage ? asset('uploads/' . $firstImage->image) : '' }}"
             alt="{{ $product->title }}"
             loading="lazy"
             onerror="this.style.display='none'">
    </a>
</div>

        {{-- معلومات المنتج --}}
        <div class="nf-product-body">

            {{-- العنوان --}}
            <a href="{{ route('product.show_details', $product->slug) }}"
               class="nf-product-title"
               title="{{ $product->title }}">
                {{ $product->title }}
            </a>

            {{-- السعر --}}
            <div class="nf-product-price-row">
                <span class="nf-product-price">{{ number_format($product->final_price ?? $product->price, 0) }}</span>
                <span class="nf-product-currency">ج.م</span>
            </div>



        </div>
    </div>
@endforeach
