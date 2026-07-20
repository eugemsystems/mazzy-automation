<x-shop::layouts>
    <x-slot:title>Polk Audio Sound System - Mazzy Automations</x-slot>

    {{-- Breadcrumb --}}
    <div class="breadcumb-wrapper" data-bg-src="{{ asset('themes/shop/konta/img/bg/breadcumb-bg.jpg') }}">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Polk Audio Sound Systems</h1>
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('shop.home.index') }}">Home</a></li>
                    <li>Polk Audio Sound Systems</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="space-top space-extra-bottom">
        <div class="container">
            <div class="row gx-5">

                {{-- Main Content Column --}}
                <div class="col-lg-8">
                    <div class="service-detail">

                        {{-- Logo & Hero --}}
                        <div class="service-detail_img mb-40">

                            <img
                                src="/other/p2.jpeg"
                                alt="Polk Audio Sound System"
                                class="w-100 rounded"
                            >
                        </div>

                        {{-- Title --}}
                        <div class="title-area mb-30">
                            <span class="sub-title"><i class="fas fa-headphones"></i> Polk Audio Sound Systems</span>
                            <h2 class="sec-title">Live for the Thrill of Glorious Audio</h2>
                        </div>

                        <p class="mb-3">
                            "Live for the thrill of glorious audio, and trust Polk to drive how you listen." Since 1972, Polk Audio has been the original Speaker Specialists — delivering rich, detailed sound for home theatre and music the way it's meant to be heard, without compromising on quality or breaking the bank.
                        </p>

                        <h3 class="h4 mt-35 mb-15">Real Reliability</h3>
                        <p class="mb-3">
                            Polk Audio sound systems take unwavering commitment, pride and passion to craft. Their speakers are built to produce sound that spans the decades — balancing innovation with advanced technology to create audio solutions that truly endure.
                        </p>

                        <h3 class="h4 mt-35 mb-15">Real Performance and Value</h3>
                        <p class="mb-3">
                            Founded on the principles established over four decades ago through the Monitor Series, Polk maintains its commitment across personal audio, wireless music products, sound bars and traditional component speakers — offering exceptional quality at an accessible price point.
                        </p>

                        <h3 class="h4 mt-35 mb-15">Real American Hi-Fi</h3>
                        <p class="mb-3">
                            Polk Audio delivers rich, detailed audio for home theatre and music the way it's meant to be heard. Exceptional sound quality paired with competitive pricing — that's the Polk promise.
                        </p>

                        {{-- Gallery --}}
                        <h3 class="h4 mt-35 mb-15">Signature Elite Series Gallery</h3>
                        <div class="row g-3 mb-40">
                            @foreach([
                                ['src' => '/other/p1.jpeg',      'alt' => 'Polk ES15'],
                                ['src' => '/other/p3.jpeg',      'alt' => 'Polk ES30'],
                                ['src' => '/other/p4.jpeg', 'alt' => 'Polk ES60 + ES30'],
                                ['src' => '/other/p5.jpeg',      'alt' => 'Polk S10'],
                                ['src' => '/other/p6.jpeg', 'alt' => 'Polk S15 + S35'],
                                ['src' => '/other/p7.jpeg','alt' => 'Polk S60 + S30'],
                            ] as $img)
                                <div class="col-sm-6 col-md-4">
                                    <img
                                        src="{{ $img['src'] }}"
                                        alt="{{ $img['alt'] }}"
                                        class="w-100 rounded"
                                        style="object-fit:cover;height:200px;"
                                        loading="lazy"
                                    >
                                </div>
                            @endforeach
                        </div>

                        {{-- CTA --}}
                        <div class="service-detail_cta d-flex flex-wrap gap-3 mt-40">
                            <a href="{{ route('shop.home.contact_us') }}" class="th-btn">
                                Make an Enquiry <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>

                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="col-lg-4 mt-5 mt-lg-0">

                    <div class="widget mb-40">
                        <h4 class="widget_title">Home Automation Brands</h4>
                        <ul class="service-menu">
                            <li><a href="{{ route('shop.home.lutron_smart_control') }}">Lutron Smart Control <i class="fas fa-arrow-right"></i></a></li>
                            <li><a href="{{ route('shop.home.wiim_home_audio') }}">WiiM Home Audio <i class="fas fa-arrow-right"></i></a></li>
                            <li><a href="{{ route('shop.home.denon_multi_room_audio') }}">Denon Multi-room Audio <i class="fas fa-arrow-right"></i></a></li>
                            <li class="active"><a href="{{ route('shop.home.polk_audio_sound_system') }}">Polk Audio Sound System <i class="fas fa-arrow-right"></i></a></li>
                        </ul>
                    </div>

                    <div class="widget contact-widget">
                        <h4 class="widget_title">Make an Enquiry</h4>
                        <div class="contact-widget_content">
                            <p>Interested in Polk Audio Sound Systems? Contact our experts for a free assessment and quote.</p>
                            <div class="info-box-wrap mb-3">
                                <div class="info-box_icon"><i class="fas fa-phone"></i></div>
                                <div>
                                    <a href="tel:{{ config('company.phone.mobile') }}" class="info-box_link">{{ config('company.phone.mobile') }}</a><br>
                                    <a href="tel:{{ config('company.phone.telephone') }}" class="info-box_link">{{ config('company.phone.telephone') }}</a>
                                </div>
                            </div>
                            <div class="info-box-wrap mb-4">
                                <div class="info-box_icon"><i class="fas fa-envelope"></i></div>
                                <a href="mailto:{{ config('company.email') }}" class="info-box_link">{{ config('company.email') }}</a>
                            </div>
                            <a href="{{ route('shop.home.contact_us') }}" class="th-btn w-100 text-center">Make an Enquiry</a>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

</x-shop::layouts>
