<x-shop::layouts>
    <x-slot:title>Lutron Smart Control - Mazzy Automations</x-slot>

    {{-- Breadcrumb --}}
    <div class="breadcumb-wrapper" data-bg-src="{{ asset('themes/shop/konta/img/bg/breadcumb-bg.jpg') }}">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Lutron Smart Control</h1>
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('shop.home.index') }}">Home</a></li>
                    <li>Lutron Smart Control</li>
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

                        {{-- Logo & Hero Image --}}
                        <div class="service-detail_img mb-40">
                            <img
                                src="/other/LivRm_Prv-Res_Orlando-CH_with-Kitchen-683x1024.jpeg"
                                alt="Lutron Pico Remotes"
                                class="w-100 rounded"
                            >
                        </div>

                        {{-- Title --}}
                        <div class="title-area mb-30">
                            <span class="sub-title"><i class="fas fa-lightbulb"></i> Lutron Smart Control</span>
                            <h2 class="sec-title">Personalised Smart Lighting, Shading &amp; Temperature Control</h2>
                        </div>

                        <p class="mb-3">
                            Lutron's <strong>RA2 Select</strong> system delivers personalised smart lighting and shade control for any home and any budget. Control your lights and shades from anywhere in the world via the Lutron App on your smartphone or tablet, or use wireless Pico remotes — supporting up to 100 devices in a single system.
                        </p>
                        <p class="mb-3">
                            Lutron's patented <strong>Clear Connect RF technology</strong> ensures your system works with precision and reliability, completely free from interference.
                        </p>

                        <h3 class="h4 mt-35 mb-15">Control When You Want It, Wherever You Are</h3>
                        <ul class="list-unstyled mb-3">
                            <li class="mb-2 d-flex align-items-start">
                                <i class="fas fa-check-circle text-theme me-3 mt-1 flex-shrink-0"></i>
                                <span>Smartphone and tablet control via the Lutron App</span>
                            </li>
                            <li class="mb-2 d-flex align-items-start">
                                <i class="fas fa-check-circle text-theme me-3 mt-1 flex-shrink-0"></i>
                                <span>Wireless Pico remotes for convenient in-room control</span>
                            </li>
                            <li class="mb-2 d-flex align-items-start">
                                <i class="fas fa-check-circle text-theme me-3 mt-1 flex-shrink-0"></i>
                                <span>Up to 100 devices per system</span>
                            </li>
                            <li class="mb-2 d-flex align-items-start">
                                <i class="fas fa-check-circle text-theme me-3 mt-1 flex-shrink-0"></i>
                                <span>Patented Clear Connect RF technology — reliable, interference-free</span>
                            </li>
                            <li class="mb-2 d-flex align-items-start">
                                <i class="fas fa-check-circle text-theme me-3 mt-1 flex-shrink-0"></i>
                                <span>Save energy while creating comfortable, inviting spaces</span>
                            </li>
                        </ul>

                        {{-- Gallery --}}
                        <h3 class="h4 mt-35 mb-15">Installations Gallery</h3>
                        <div class="row g-3 mb-40">
                            @foreach([
                                ['src' => '/other/LivRm_Prv-Res_Orlando-CH_with-Kitchen-683x1024.jpeg',      'alt' => 'Living Room Installation'],
                                ['src' => '/other/PK2-3BRL-TAW-L01_Place-on-Wall-1-1024x899.jpg',             'alt' => 'Lutron Wall Control'],
                                ['src' => '/other/BH5A0326-1024x683.jpg',    'alt' => 'Exterior Lighting Day'],
                                ['src' => '/other/Ext_Prv-Res_Orlando-F_Dusk_Back-Yard-1-768x513.jpg',       'alt' => 'Exterior Lighting Dusk'],
                                ['src' => '/other/PJ2-3BRL-GWH-L01_ShinyFall19_Black-Gold-Tile-768x512.jpeg','alt' => 'Lutron Keypad Gold'],
                                ['src' => '/other/HM076-HOMEMATION-JUNE-2024-SOCIAL-MEDIA-A-LUTRON-RA2-CAROUSEL-1-4.jpg','alt' => 'Lutron RA2 Carousel'],
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
                            <li class="active"><a href="{{ route('shop.home.lutron_smart_control') }}">Lutron Smart Control <i class="fas fa-arrow-right"></i></a></li>
                            <li><a href="{{ route('shop.home.wiim_home_audio') }}">WiiM Home Audio <i class="fas fa-arrow-right"></i></a></li>
                            <li><a href="{{ route('shop.home.denon_multi_room_audio') }}">Denon Multi-room Audio <i class="fas fa-arrow-right"></i></a></li>
                            <li><a href="{{ route('shop.home.polk_audio_sound_system') }}">Polk Audio Sound System <i class="fas fa-arrow-right"></i></a></li>
                        </ul>
                    </div>

                    <div class="widget contact-widget">
                        <h4 class="widget_title">Make an Enquiry</h4>
                        <div class="contact-widget_content">
                            <p>Interested in Lutron Smart Control? Contact our experts for a free assessment and quote.</p>
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
