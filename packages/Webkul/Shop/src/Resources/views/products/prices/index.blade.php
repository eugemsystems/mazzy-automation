@php
    $isEnquireOnly = $product->hide_price
        && (float) ($prices['final']['price'] ?? 0) <= 0
        && (float) ($prices['regular']['price'] ?? 0) <= 0;
@endphp

@if ($isEnquireOnly)
    {{--
        Plain anchor, not the interactive modal — this partial's rendered
        HTML is also injected via Vue's v-html on product cards, which does
        not mount nested Vue components. The full "Enquire Now" modal lives
        on the product detail page instead, next to the Add to Cart button.
    --}}
    <a
        href="{{ $product->url_key ? url($product->url_key) : 'javascript:void(0)' }}"
        class="final-price font-semibold text-[#332a5e] underline max-sm:leading-4"
    >
        @lang('shop::app.products.view.enquire-now')
    </a>
@elseif ($product->hide_price && ! auth('customer')->check())
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
