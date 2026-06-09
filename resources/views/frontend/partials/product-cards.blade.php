@foreach($products as $product)
    <div class="prod-card min-w-[160px] w-[160px] md:min-w-[200px] md:w-[200px]">

        <a href="{{ route('product.show_details', $product->slug) }}" class="block">

            {{-- صورة --}}
            <div class="relative aspect-square bg-gray-50 p-4">
                @php $firstImage = $product->images->first(); @endphp

                <img src="{{ $firstImage ? asset('uploads/' . $firstImage->image) : asset('images/no-image.png') }}"
                     alt="{{ $product->title }}"
                     class="w-full h-full object-contain"
                     loading="lazy"
                     onerror="this.src='{{ asset('images/no-image.png') }}'">

                @if($product->discount > 0)
                    <span class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                        -{{ $product->discount }}%
                    </span>
                @endif
            </div>

            {{-- معلومات --}}
            <div class="p-3">
                <h3 class="text-sm font-semibold text-gray-900 line-clamp-2 mb-1" style="min-height: 2.6rem;">
                    {{ $product->title }}
                </h3>

                <div class="flex items-center gap-1 mb-2">
                    <div class="flex text-yellow-400 text-xs">
                        @php $rating = $product->rating ?? 4.5; @endphp
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($rating))
                                <i class="fas fa-star"></i>
                            @elseif($i == ceil($rating) && $rating != floor($rating))
                                <i class="fas fa-star-half-alt"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </div>
                    <span class="text-xs text-gray-500">({{ $rating }})</span>
                </div>

                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-lg font-bold text-[#E02954]">
                            {{ number_format($product->final_price ?? $product->price, 0) }}
                        </span>
                        <span class="text-xs text-gray-500">EGP</span>
                    </div>
                    @if($product->discount > 0)
                        <span class="text-xs text-gray-400 line-through">
                            {{ number_format($product->price, 0) }}
                        </span>
                    @endif
                </div>
            </div>
        </a>

        {{-- زر السلة --}}
        <div class="px-3 pb-3">
            <button type="button"
                    onclick="event.preventDefault(); event.stopPropagation(); addToCart({{ $product->id }})"
                    class="w-full py-2 bg-gray-900 text-white text-xs font-semibold rounded-lg hover:bg-gray-800 transition-colors">
                <i class="fas fa-cart-plus mr-1"></i>
                {{ trans_lang('أضف للسلة', 'Add to Cart') }}
            </button>
        </div>
    </div>
@endforeach
