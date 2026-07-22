@component('shop::emails.layout')
    <p style="font-size: 16px;color: #384860;line-height: 24px;margin-bottom: 8px;">
        <strong>Product:</strong>
        <a href="{{ $enquiryData['product_url'] }}">{{ $enquiryData['product_name'] }}</a>
    </p>

    @if (! empty($enquiryData['product_sku']))
        <p style="font-size: 14px;color: #6b7280;margin-bottom: 24px;">
            <strong>SKU:</strong> {{ $enquiryData['product_sku'] }}
        </p>
    @endif

    <div style="margin-bottom: 34px;">
        <p style="font-size: 16px;color: #384860;line-height: 24px;">
            {{ $enquiryData['message'] }}
        </p>
    </div>

    <p style="font-size: 16px;color: #384860;line-height: 24px;margin-bottom: 40px">
        From: <strong>{{ $enquiryData['name'] }}</strong> —
        <a href="mailto:{{ $enquiryData['email'] }}">{{ $enquiryData['email'] }}</a>

        @if (! empty($enquiryData['phone']))
            | <a href="tel:{{ $enquiryData['phone'] }}">{{ $enquiryData['phone'] }}</a>
        @endif
    </p>
@endcomponent
