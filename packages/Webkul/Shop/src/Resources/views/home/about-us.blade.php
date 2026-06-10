<x-shop::layouts>
    <x-slot:title>Who We Are - Mazzy Automations</x-slot>

    {{-- Breadcrumb --}}
    <div class="breadcumb-wrapper" data-bg-src="{{ asset('themes/shop/konta/img/bg/breadcumb-bg.jpg') }}">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">About Us</h1>
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('shop.home.index') }}">Home</a></li>
                    <li>Who We Are</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- About Company --}}
    <div class="overflow-hidden space">
        <div class="container">
            <div class="row align-items-center">
                <!-- Left Side: Images & Experience Badge -->
                <div class="col-xl-6">
                    <div class="img-box1 shape-mockup-wrap">
                        <div class="img1">
                            <img class="tilt-active" src="{{ asset('themes/shop/konta/img/normal/about_1_1.jpg') }}" alt="About Mazzy" style="will-change: transform; transform: perspective(1000px) rotateX(0deg) rotateY(0deg); transition: 400ms cubic-bezier(0.03, 0.98, 0.52, 0.99);">
                        </div>
                        <div class="about-grid">
                            <h3 class="about-grid_year">5<span>+</span></h3>
                            <p style="color: #1c1c1c !important;" class="about-grid_text">Years Experience in Home &amp; Industrial Automation</p>
                        </div>
                        <div class="img2">
                            <img class="tilt-active" src="{{ asset('themes/shop/konta/img/normal/about_1_2.jpg') }}" alt="Automation" style="will-change: transform; transform: perspective(1000px) rotateX(0deg) rotateY(0deg);">
                        </div>
                        <div class="shape-mockup about-shape1 jump" style="bottom: 0px; left: -67px;">
                            <img src="{{ asset('themes/shop/konta/img/normal/about_1_shape1.png') }}" alt="Shape">
                        </div>
                    </div>
                </div>

                <!-- Right Side: Text, Features, & Button -->
                <div class="col-xl-6">
                    <div class="title-area mb-30">
                        <span style="color: #95AAD5" class="sub-title subtitle-selector"> About Mazzy Automations</span>
                        <h2 style="color: #1c1c1c !important;" class="sec-title fw-semibold">Your Number 1 Choice Installers in SA</h2>
                    </div>
                    <p style="color: #1c1c1c !important;" class="mt-n2 mb-35">
                        Mazzy Automations is a fully registered company that specializes in automation systems from design,
                        supply, installation and services for both home and Industrial in South Africa and the world at
                        large at very competitive prices. At Mazzy Automations we will always talk with our clients first
                        and get a feel for what they want to achieve and how much they are thinking of spending, before we go
                        off and design the best solution for both your budget and your needs. We will always try to find the
                        best for you in terms of performance vs. cost.
                    </p>

                    <!-- Feature 1: Worldwide Vision -->
                    <div class="about-grid2">
                        <div class="icon">
                            <img decoding="async" src="{{asset('themes/shop/konta/img/normal/about-grid-icon1.svg')}}" alt="about grid icon1">
                        </div>
                        <div class="about-grid-details">
                            <h3 style="color: #8a8a8a !important;" class="about-grid_title h6">Worldwide Vision</h3>
                            <p style="color: #1c1c1c !important;">We strive to develop cutting-edge automation solutions that transform homes and the way businesses operate and thrive.</p>
                        </div>
                    </div>

                    <!-- Feature 2: Mission Statement -->
                    <div class="about-grid2">
                        <div class="icon">
                            <img decoding="async" src="{{asset('themes/shop/konta/img/normal/about-grid-icon2.svg')}}" alt="about grid icon2">
                        </div>
                        <div class="about-grid-details">
                            <h3 style="color: #8a8a8a !important;" class="about-grid_title h6">Our Mission Statement</h3>
                            <p style="color: #1c1c1c !important;">Our mission at Mazzy Automations is to design, develop, and deliver innovative automation solutions that exceed customer expectations, drive operational excellence, and foster long-term partnerships</p>
                        </div>
                    </div>

                    <div class="btn-group mt-40">
                        <a href="{{asset('Mazzy-Automations-catalog-company-profile.pdf')}}" class="th-btn">Download Our Company Profile<i class="fa-regular fa-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 4-Step Process --}}
    <div class="bg-smoke space">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center wow fadeInUp" data-wow-delay=".2s">
                    <div class="title-area mb-50">
                        <span class="sub-title"><i class="fas fa-list-ol"></i> How It Works</span>
                        <h2 class="sec-title">Our 4-Step Process</h2>
                    </div>
                </div>
            </div>
            <div class="row gy-40 justify-content-between" bis_skin_checked="1"><div class="col-sm-6 col-lg-auto process-card2-wrap" bis_skin_checked="1"><div class="process-card2" bis_skin_checked="1"><div class="process-card2_icon" bis_skin_checked="1"><i class="fas fa-grid"></i></div><h3 class="process-card2_title title-selector">Enquiry Stage</h3><p class="process-card2_text desc-selector">Customer makes an Enquiry</p></div></div><div class="col-sm-6 col-lg-auto process-card2-wrap" bis_skin_checked="1"><div class="process-card2" bis_skin_checked="1"><div class="process-card2_icon" bis_skin_checked="1"><i class="fas fa-grid"></i></div><h3 class="process-card2_title title-selector">Quotation Stage</h3><p class="process-card2_text desc-selector">We respond with a Quotation</p></div></div><div class="col-sm-6 col-lg-auto process-card2-wrap" bis_skin_checked="1"><div class="process-card2" bis_skin_checked="1"><div class="process-card2_icon" bis_skin_checked="1"><i class="fas fa-grid"></i></div><h3 class="process-card2_title title-selector">Planning and Design Stage</h3><p class="process-card2_text desc-selector">Customer makes payment for the service</p></div></div><div class="col-sm-6 col-lg-auto process-card2-wrap" bis_skin_checked="1"><div class="process-card2" bis_skin_checked="1"><div class="process-card2_icon" bis_skin_checked="1"><i class="fas fa-grid"></i></div><h3 class="process-card2_title title-selector">Installation Stage</h3><p class="process-card2_text desc-selector">Client makes a deposit and service kits are installed.</p></div></div></div>
        </div>
    </div>

    {{-- CTA --}}
    <div class="cta-area space" data-bg-src="{{ asset('themes/shop/konta/img/bg/cta-bg.jpg') }}">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-sm-12 wow fadeInUp" data-wow-delay=".2s">
                    <div class="d-flex flex-wrap gap-3 justify-content-center">
                        <a href="{{ route('shop.home.contact_us') }}" class="th-btn">Contact Us Today<i class="fas fa-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-shop::layouts>
