@component('shop::emails.layout')
    @if(!empty($contactUs['subject']))
        <p style="font-size: 14px;color: #6b7280;margin-bottom: 8px;"><strong>Subject:</strong> {{ $contactUs['subject'] }}</p>
    @endif

    <div style="margin-bottom: 34px;">
        <p style="font-size: 16px;color: #384860;line-height: 24px;">
            {{ $contactUs['message'] }}
        </p>
    </div>

    <p style="font-size: 16px;color: #384860;line-height: 24px;margin-bottom: 40px">
        @lang('shop::app.emails.contact-us.to')

        <a href="mailto:{{ $contactUs['email'] }}">{{ $contactUs['email'] }}</a>,

        @lang('shop::app.emails.contact-us.reply-to-mail')

        @if(!empty($contactUs['contact']))
            @lang('shop::app.emails.contact-us.reach-via-phone')

            <a href="tel:{{ $contactUs['contact'] }}">{{ $contactUs['contact'] }}</a>.
        @endif
    </p>
@endcomponent