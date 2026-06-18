<x-shop::layouts>
    <x-slot:title>WiiM Home Audio - Mazzy Automations</x-slot>

    {{-- Breadcrumb --}}
    <div class="breadcumb-wrapper" data-bg-src="{{ asset('themes/shop/konta/img/bg/breadcumb-bg.jpg') }}">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">WiiM Home Audio</h1>
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('shop.home.index') }}">Home</a></li>
                    <li>WiiM Home Audio</li>
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
                                src="/other/w2.jpg"
                                alt="WiiM Home Audio Installation"
                                class="w-100 rounded"
                            >
                        </div>

                        {{-- Title --}}
                        <div class="title-area mb-30">
                            <span class="sub-title"><i class="fas fa-music"></i> WiiM Home Audio</span>
                            <h2 class="sec-title">High-Fidelity Wireless Audio for Every Room</h2>
                        </div>

                        <p class="mb-3">
                            WiiM is at the forefront of audio innovation, delivering high-fidelity sound experiences through its cutting-edge wireless audio devices. With seamless connectivity and superior sound quality, WiiM transforms your home into an immersive listening environment — whether for casual streaming or a full home theatre setup.
                        </p>

                        <h3 class="h4 mt-35 mb-15">Why Choose WiiM?</h3>
                        <ul class="list-unstyled mb-3">
                            <li class="mb-2 d-flex align-items-start">
                                <i class="fas fa-check-circle text-theme me-3 mt-1 flex-shrink-0"></i>
                                <span>High-fidelity wireless audio streaming</span>
                            </li>
                            <li class="mb-2 d-flex align-items-start">
                                <i class="fas fa-check-circle text-theme me-3 mt-1 flex-shrink-0"></i>
                                <span>Seamless multi-room audio connectivity</span>
                            </li>
                            <li class="mb-2 d-flex align-items-start">
                                <i class="fas fa-check-circle text-theme me-3 mt-1 flex-shrink-0"></i>
                                <span>Compatible with major streaming services</span>
                            </li>
                            <li class="mb-2 d-flex align-items-start">
                                <i class="fas fa-check-circle text-theme me-3 mt-1 flex-shrink-0"></i>
                                <span>Simple setup and intuitive app control</span>
                            </li>
                            <li class="mb-2 d-flex align-items-start">
                                <i class="fas fa-check-circle text-theme me-3 mt-1 flex-shrink-0"></i>
                                <span>Ideal for home theatre and whole-home audio</span>
                            </li>
                        </ul>

                        {{-- Gallery --}}
                        <h3 class="h4 mt-35 mb-15">Installations Gallery</h3>
                        <div class="row g-3 mb-40">
                            @foreach([
                                ['src' => '/other/w3.jpg',                          'alt' => 'WiiM Installation 1'],
                                ['src' => '/other/w4.jpg',                          'alt' => 'WiiM Installation 2'],
                                ['src' => '/other/w5.jpg',                          'alt' => 'WiiM Installation 3'],
                                ['src' => '/other/w6.jpg',                          'alt' => 'WiiM Installation 4'],
                                ['src' => '/other/w7.jpg',   'alt' => 'WiiM System'],
                                ['src' => '/other/w8.jpg',                          'alt' => 'WiiM Installation 5'],
                                ['src' => '/other/w9.jpg',                          'alt' => 'WiiM Installation 6'],
                                ['src' => '/other/w1.jpg',                         'alt' => 'WiiM Installation 7'],
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
                            <li class="active"><a href="{{ route('shop.home.wiim_home_audio') }}">WiiM Home Audio <i class="fas fa-arrow-right"></i></a></li>
                            <li><a href="{{ route('shop.home.denon_multi_room_audio') }}">Denon Multi-room Audio <i class="fas fa-arrow-right"></i></a></li>
                            <li><a href="{{ route('shop.home.polk_audio_sound_system') }}">Polk Audio Sound System <i class="fas fa-arrow-right"></i></a></li>
                        </ul>
                    </div>

                    <div class="widget contact-widget">
                        <h4 class="widget_title">Make an Enquiry</h4>
                        <div class="contact-widget_content">
                            <p>Interested in WiiM Home Audio? Contact our experts for a free assessment and quote.</p>
                            <div class="info-box-wrap mb-3">
                                <div class="info-box_icon"><i class="fas fa-phone"></i></div>
                                <div>
                                    <a href="tel:+27787972186" class="info-box_link">+27 787 972 186</a><br>
                                    <a href="tel:0107463674" class="info-box_link">010 746 3674</a>
                                </div>
                            </div>
                            <div class="info-box-wrap mb-4">
                                <div class="info-box_icon"><i class="fas fa-envelope"></i></div>
                                <a href="mailto:info@mazzyautomations.co.za" class="info-box_link">info@mazzyautomations.co.za</a>
                            </div>
                            <a href="{{ route('shop.home.contact_us') }}" class="th-btn w-100 text-center">Make an Enquiry</a>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

</x-shop::layouts>
