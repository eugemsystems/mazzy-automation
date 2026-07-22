@php
    $isEnquireOnly = $product->hide_price && ! auth('customer')->check();
@endphp

@if ($isEnquireOnly)
    {{--
        Intentionally blank — the actual "Enquire Now" call-to-action is
        the button that replaces Add to Cart / Buy Now (see card.blade.php
        for listings, view.blade.php for the product detail page), so this
        price slot doesn't need to duplicate it.
    --}}
@elseif ($prices['final']['price'] < $prices['regular']['price'])
    <p
        class="final-price font-medium text-slate-500 line-through max-sm:leading-4"
        aria-label="{{ $prices['regular']['formatted_price'] }}"
    >
        {{ $prices['regular']['formatted_price'] }}
    </p>

    <p class="font-semibold max-sm:leading-4">
        {{ $prices['final']['formatted_price'] }}
    </p>
@else
    <p class="final-price font-semibold max-sm:leading-4">
        {{ $prices['regular']['formatted_price'] }}
    </p>
@endif
