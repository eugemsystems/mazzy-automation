<x-shop::layouts>
    <x-slot:title>Denon Multi-room Audio - Mazzy Automations</x-slot>

    {{-- Breadcrumb --}}
    <div class="breadcumb-wrapper" data-bg-src="{{ asset('themes/shop/konta/img/bg/breadcumb-bg.jpg') }}">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Denon Multi-room Audio</h1>
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('shop.home.index') }}">Home</a></li>
                    <li>Denon Multi-room Audio</li>
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
                                src="/other/d1.jpeg"
                                alt="Denon Home 350 Speaker"
                                class="w-100 rounded"
                            >
                        </div>

                        {{-- Title --}}
                        <div class="title-area mb-30">
                            <span class="sub-title"><i class="fas fa-volume-up"></i> Denon Multi-room Audio</span>
                            <h2 class="sec-title">Over a Century of Audio Innovation</h2>
                        </div>

                        <p class="mb-3">
                            With over a century of audio innovation dating back to 1910, Denon has been crafting exceptional theatre sounds and hi-fi equipment since Frederick Whitney Horn established Japan's first-ever audio equipment company. Today, Denon continues this legacy with a full ecosystem of AV receivers, amplifiers, and wireless speakers designed for your home.
                        </p>

                        <h3 class="h4 mt-35 mb-15">Denon AV Receiver</h3>
                        <p class="mb-3">
                            Denon AV Surround Receivers deliver the full home theatre experience — from crisp dialogue to powerful surround sound. Whether you're watching the latest blockbuster or immersing yourself in music, a Denon AV receiver is the heart of your entertainment system.
                        </p>
                        <div class="row g-3 mb-3">
                            @foreach([
                                ['src' => '/other/d2.jpeg',      'alt' => 'Denon AVR X2800'],
                                ['src' => '/other/d3.jpeg',  'alt' => 'Denon AVR X1800H'],
                            ] as $img)
                                <div class="col-sm-6">
                                    <img src="{{ $img['src'] }}" alt="{{ $img['alt'] }}" class="w-100 rounded" style="object-fit:cover;height:200px;" loading="lazy">
                                </div>
                            @endforeach
                        </div>

                        <h3 class="h4 mt-35 mb-15">Denon Amplifier</h3>
                        <p class="mb-3">
                            Precision, craftsmanship and innovation — Denon amplifiers deliver exceptional clarity and power, supporting vinyl, CD, streaming and more. Experience your music the way the artists intended.
                        </p>

                        <h3 class="h4 mt-35 mb-15">Denon Wireless Speakers (Denon Home)</h3>
                        <p class="mb-3">
                            The Denon Home wireless speaker ecosystem (HEOS) lets you fill every room with music. Choose from five models and enjoy synchronised multi-room playback, touch controls and Dolby Atmos sound.
                        </p>
                        <ul class="list-unstyled mb-3">
                            <li class="mb-2 d-flex align-items-start"><i class="fas fa-check-circle text-theme me-3 mt-1 flex-shrink-0"></i><span>Denon Home 150 — compact wireless speaker</span></li>
                            <li class="mb-2 d-flex align-items-start"><i class="fas fa-check-circle text-theme me-3 mt-1 flex-shrink-0"></i><span>Denon Home 250 — mid-size hi-fi speaker</span></li>
                            <li class="mb-2 d-flex align-items-start"><i class="fas fa-check-circle text-theme me-3 mt-1 flex-shrink-0"></i><span>Denon Home 350 — flagship wireless speaker</span></li>
                            <li class="mb-2 d-flex align-items-start"><i class="fas fa-check-circle text-theme me-3 mt-1 flex-shrink-0"></i><span>Denon Home 550 Soundbar — Dolby Atmos soundbar</span></li>
                            <li class="mb-2 d-flex align-items-start"><i class="fas fa-check-circle text-theme me-3 mt-1 flex-shrink-0"></i><span>Denon Home Subwoofer — deep bass extension</span></li>
                        </ul>

                        {{-- Speaker Gallery --}}
                        <h3 class="h4 mt-35 mb-15">Gallery</h3>
                        <div class="row g-3 mb-40">
                            @foreach([
                                ['src' => '/other/d4.jpeg','alt' => 'Denon Home 150 White'],
                                ['src' => '/other/d5.jpeg','alt' => 'Denon Home 150 Black'],
                                ['src' => '/other/d6.jpeg','alt' => 'Denon Home 150 Bedroom'],
                                ['src' => '/other/d7.jpeg','alt' => 'Denon 5.1 System'],
                                ['src' => '/other/d8.jpeg','alt' => 'Denon Home 550 Gaming'],
                                ['src' => '/other/d9.jpeg','alt' => 'Denon Home 250 White'],
                                ['src' => '/other/d10.jpeg','alt' => 'Denon Home 250 In Situ'],
                                ['src' => '/other/d11.jpeg','alt' => 'Denon Gaming System'],
                                ['src' => '/other/d12.jpeg','alt' => 'Denon Gaming System'],
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
                            <li class="active"><a href="{{ route('shop.home.denon_multi_room_audio') }}">Denon Multi-room Audio <i class="fas fa-arrow-right"></i></a></li>
                            <li><a href="{{ route('shop.home.polk_audio_sound_system') }}">Polk Audio Sound System <i class="fas fa-arrow-right"></i></a></li>
                        </ul>
                    </div>

                    <div class="widget contact-widget">
                        <h4 class="widget_title">Make an Enquiry</h4>
                        <div class="contact-widget_content">
                            <p>Interested in Denon Multi-room Audio? Contact our experts for a free assessment and quote.</p>
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
