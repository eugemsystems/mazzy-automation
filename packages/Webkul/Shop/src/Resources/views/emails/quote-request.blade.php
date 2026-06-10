@component('shop::emails.layout')
    @if(!empty($quoteData['subject']))
        <p style="font-size: 14px;color: #6b7280;margin-bottom: 8px;"><strong>Quote Type:</strong> {{ $quoteData['subject'] }}</p>
    @endif

    <div style="margin-bottom: 34px;">
        <p style="font-size: 16px;color: #384860;line-height: 24px;">
            {{ $quoteData['message'] }}
        </p>
    </div>

    <p style="font-size: 16px;color: #384860;line-height: 24px;margin-bottom: 40px">
        From: <strong>{{ $quoteData['name'] }}</strong> —
        <a href="mailto:{{ $quoteData['email'] }}">{{ $quoteData['email'] }}</a>

        @if(!empty($quoteData['phone']))
            | <a href="tel:{{ $quoteData['phone'] }}">{{ $quoteData['phone'] }}</a>
        @endif
    </p>
@endcomponent
