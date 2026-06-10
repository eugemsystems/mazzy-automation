@push('meta')
    <meta name="title" content="Mazzy Automations - Smart Automation Systems Providers" />
    <meta name="description" content="We specialize in automation systems from design, supply, installation and services for both home and Industrial in South Africa" />
    <meta name="keywords" content="home automation, smart lighting, security systems, industrial automation, South Africa" />
@endPush

<x-shop::layouts>
    <x-slot:title>Welcome to Mazzy Automations - Smart Automation Systems Providers</x-slot>

    {{-- ===== HERO SLIDER ===== --}}
    <div class="th-hero-wrapper hero-1" id="hero">
        <div class="hero-slider-1 th-carousel" data-fade="true" data-slide-show="1" data-md-slide-show="1" data-dots="true" data-adaptive-height="true">

            {{-- Slide 1 --}}
            <div class="th-hero-slide">
                <div class="th-hero-bg" data-bg-src="{{ asset('themes/shop/konta/img/hero/hero_bg_1_1.jpg') }}">
                    {{--                    <img src="{{ asset('themes/shop/konta/img/hero/hero_overlay_1_1.jpg') }}" alt="">--}}
                </div>
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xxl-8 col-lg-7 col-md-8">
                            <div class="hero-style1">
                                <span class="hero-subtitle" data-ani="slideinleft" data-ani-delay="0.1s">Smart Automation Systems Providers</span>
                                <h1 class="hero-title" data-ani="slideinleft" data-ani-delay="0.4s">Welcome to <br><span class="text-theme">Mazzy Automations</span></h1>
                                <p style="color: #362A5E !important" class="hero-text" data-ani="slideinleft" data-ani-delay="0.6s">We specialize in automation systems from design, supply, installation and services for both home and Industrial in South Africa</p>
                                <div class="btn-group" data-ani="slideinleft" data-ani-delay="0.8s">
                                    <a href="{{ route('shop.home.about_us') }}" class="th-btn style4 th-icon">More About Us</a>
                                    <a href="{{ route('shop.search.index') }}" class="th-btn ms-3">Visit Shop <i class="fas fa-arrow-right ms-1"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Slide 2: Smart Gateway --}}
            <div class="th-hero-slide">
                <div class="th-hero-bg" data-bg-src="{{ asset('themes/shop/konta/img/hero/hero_bg_1_2.jpg') }}">
                    {{--                    <img src="{{ asset('themes/shop/konta/img/hero/hero_overlay_1_1.jpg') }}" alt="">--}}
                </div>
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xxl-8 col-lg-7 col-md-8">
                            <div class="hero-style1">
                                <span class="hero-subtitle" data-ani="slideinleft" data-ani-delay="0.1s">Smart Home Integration</span>
                                <h1 class="hero-title" data-ani="slideinleft" data-ani-delay="0.4s">Smart Central Control<br><span class="text-theme">Screen Gateway</span></h1>
                                <p style="color: #362A5E !important" class="hero-text" data-ani="slideinleft" data-ani-delay="0.6s">Implementing Custom Smart gateways that are designed to translate between different smart device communication protocols. This allows devices using different standards such as WiFi, Bluetooth, Zigbee and Z-Wave to communicate with each other.</p>
                                <div class="btn-group" data-ani="slideinleft" data-ani-delay="0.8s">
                                    <a href="{{ route('shop.search.index') }}" class="th-btn style4 th-icon">Visit Shop</a>
                                    <a href="{{ route('shop.home.contact_us') }}" class="th-btn ms-3">Contact Us <i class="fas fa-arrow-right ms-1"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Slide 3: Smart Curtain --}}
            <div class="th-hero-slide">
                <div class="th-hero-bg" data-bg-src="{{ asset('themes/shop/konta/img/hero/hero_bg_1_3.jpg') }}">
                    {{--                    <img src="{{ asset('themes/shop/konta/img/hero/hero_overlay_1_1.jpg') }}" alt="">--}}
                </div>
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xxl-8 col-lg-7 col-md-8">
                            <div class="hero-style1">
                                <span class="hero-subtitle" data-ani="slideinleft" data-ani-delay="0.1s">Home Automation</span>
                                <h1 class="hero-title" data-ani="slideinleft" data-ani-delay="0.4s">Smart Curtain <br><span class="text-theme">Systems</span></h1>
                                <p style="color: #362A5E !important" class="hero-text" data-ani="slideinleft" data-ani-delay="0.6s">Our controls allow you to open, close, and adjust your motorized curtains remotely via smartphone, voice commands, or automated schedules</p>
                                <div class="btn-group" data-ani="slideinleft" data-ani-delay="0.8s">
                                    <a href="{{ route('shop.home.solutions', 'smart-curtain-systems') }}" class="th-btn style4 th-icon">Get More Info</a>
                                    <a href="{{ route('shop.search.index') }}" class="th-btn ms-3">Visit Shop <i class="fas fa-arrow-right ms-1"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Slide 4: Smart Alarm --}}
            <div class="th-hero-slide">
                <div class="th-hero-bg" data-bg-src="{{ asset('themes/shop/konta/img/hero/hero_bg_2_1.jpg') }}">
                    {{--                    <img src="{{ asset('themes/shop/konta/img/hero/hero_overlay_1_1.jpg') }}" alt="">--}}
                </div>
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xxl-8 col-lg-7 col-md-8">
                            <div class="hero-style1">
                                <span class="hero-subtitle" data-ani="slideinleft" data-ani-delay="0.1s">Your Security is our concern</span>
                                <h1 class="hero-title" data-ani="slideinleft" data-ani-delay="0.4s">Smart Alarm <br><span class="text-theme">Systems</span></h1>
                                <p style="color: #362A5E !important" class="hero-text" data-ani="slideinleft" data-ani-delay="0.6s">We favor state-of-the-art alarms that will detect attempted break-ins, enabling you to react quickly and effectively in an emergency.</p>
                                <div class="btn-group" data-ani="slideinleft" data-ani-delay="0.8s">
                                    <a href="{{ route('shop.home.solutions', 'alarm-and-access-control') }}" class="th-btn style4 th-icon">Get More Info</a>
                                    <a href="{{ route('shop.search.index') }}" class="th-btn ms-3">Visit Shop <i class="fas fa-arrow-right ms-1"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Slide 5: Smart Lighting --}}
            <div class="th-hero-slide">
                <div class="th-hero-bg" data-bg-src="{{ asset('themes/shop/konta/img/hero/hero_bg_2_2.jpg') }}">
                    {{--                    <img src="{{ asset('themes/shop/konta/img/hero/hero_overlay_1_1.jpg') }}" alt="">--}}
                </div>
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xxl-8 col-lg-7 col-md-8">
                            <div class="hero-style1">
                                <span class="hero-subtitle" data-ani="slideinleft" data-ani-delay="0.1s">Let there be light</span>
                                <h1 class="hero-title" data-ani="slideinleft" data-ani-delay="0.4s">Smart Lighting <br><span class="text-theme">Systems</span></h1>
                                <p style="color: #362A5E !important" class="hero-text" data-ani="slideinleft" data-ani-delay="0.6s">Lighting by a remote or voice, and schedule lights to turn on or off. Some lights give a custom color</p>>
                                <div class="btn-group" data-ani="slideinleft" data-ani-delay="0.8s">
                                    <a href="{{ route('shop.home.solutions', 'smart-lighting-systems') }}" class="th-btn style4 th-icon">Get More Info</a>
                                    <a href="{{ route('shop.search.index') }}" class="th-btn ms-3">Visit Shop <i class="fas fa-arrow-right ms-1"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Slide 6: CCTV --}}
            <div class="th-hero-slide">
                <div class="th-hero-bg" data-bg-src="{{ asset('themes/shop/konta/img/hero/hero_bg_2_3.jpg') }}">
                    {{--                    <img src="{{ asset('themes/shop/konta/img/hero/hero_overlay_1_1.jpg') }}" alt="">--}}
                </div>
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xxl-8 col-lg-7 col-md-8">
                            <div class="hero-style1">
                                <span class="hero-subtitle" data-ani="slideinleft" data-ani-delay="0.1s">CCTV Solutions</span>
                                <h1 class="hero-title" data-ani="slideinleft" data-ani-delay="0.4s">CCTV Setting up <br><span class="text-theme">& Installations</span></h1>
                                <p style="color: #362A5E !important" class="hero-text" data-ani="slideinleft" data-ani-delay="0.6s">Unlock the Future of Smart Living with Mazzy Automation Systems</p>
                                <div class="btn-group" data-ani="slideinleft" data-ani-delay="0.8s">
                                    <a href="{{ route('shop.home.solutions', 'smart-security-sensors') }}" class="th-btn style4 th-icon">Get More Info</a>
                                    <a href="{{ route('shop.search.index') }}" class="th-btn ms-3">Visit Shop <i class="fas fa-arrow-right ms-1"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="hero-shape"></div>
    </div>

    {{-- ===== ABOUT SECTION ===== --}}
    <div style="background-color: #352A5E !important;" class="overflow-hidden space overflow-hidden" id="about-sec-2">
        <div class="container">
            <div class="row align-items-center">
                <!-- Left Side: Images & Experience Badge -->
                <div class="col-xl-6">
                    <div class="img-box1 shape-mockup-wrap">
                        <div class="img1">
                            <img class="tilt-active" src="{{ asset('themes/shop/konta/img/normal/about_1_1.jpg') }}" alt="About Mazzy" style="will-change: transform; transform: perspective(1000px) rotateX(0deg) rotateY(0deg); transition: 400ms cubic-bezier(0.03, 0.98, 0.52, 0.99);">
                        </div>
                        <div class="about-grid">
                            <h3 class="about-grid_year"><span class="counter-number">5</span><span>+</span></h3>
                            <p style="color: #FFFFFF !important;" class="about-grid_text">Years Experience in Home &amp; Industrial Automation</p>
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
                        <h2 style="color: #FFFFFF !important;" class="sec-title fw-semibold">Your Number 1 Choice Installers in SA</h2>
                    </div>
                    <p style="color: #FFFFFF !important;" class="mt-n2 mb-35">Mazzy Automations is a fully registered company that specializes in automation systems from design, supply, installation and services for both home and Industrial in South Africa and the world at large at very competitive prices.</p>

                    <!-- Feature 1: Worldwide Vision -->
                    <div class="about-grid2">
                        <div class="icon">
                            <img decoding="async" src="{{asset('themes/shop/konta/img/normal/about-grid-icon1.svg')}}" alt="about grid icon1">
                        </div>
                        <div class="about-grid-details">
                            <h3 style="color: #8a8a8a !important;" class="about-grid_title h6">Worldwide Vision</h3>
                            <p style="color: #FFFFFF !important;">We strive to develop cutting-edge automation solutions that transform homes and the way businesses operate and thrive.</p>
                        </div>
                    </div>

                    <!-- Feature 2: Mission Statement -->
                    <div class="about-grid2">
                        <div class="icon">
                            <img decoding="async" src="{{asset('themes/shop/konta/img/normal/about-grid-icon2.svg')}}" alt="about grid icon2">
                        </div>
                        <div class="about-grid-details">
                            <h3 style="color: #8a8a8a !important;" class="about-grid_title h6">Our Mission Statement</h3>
                            <p style="color: #FFFFFF !important;">Our mission at Mazzy Automations is to design, develop, and deliver innovative automation solutions that exceed customer expectations, drive operational excellence, and foster long-term partnerships</p>
                        </div>
                    </div>

                    <div class="btn-group mt-40">
                        <a href="{{ route('shop.home.about_us') }}" class="th-btn">More About Us<i class="fa-regular fa-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== CORE SE  RVICES ===== --}}
    <section class="z-index-commonx" style="margin-bottom: 0px !important;">
        <div class="container th-container2">
            <div style="padding: 80px;position: relative;">
                <div class="row align-items-center justify-content-between">
                    <div class="col-md-8 col-sm-12">
                        <div class="title-area mb-xl-0 text-center text-xl-start mb-50">
                            <span class=" sub-title subtitle-selector">Our Core Services</span>
                            <h2 class="sec-title fw-semibold">Control all your devices from your phone, tablet or desktop.</h2>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="counter-wrap4">
                            <a href="#" class="th-btn mt-10">View All Services <i class="fa-regular fa-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== TABS ===== --}}
    <section style="background-color: transparent; background-image: linear-gradient(107deg, #352A5E 0%, #4A3D7B 53%);"
             class="overflow-hidden space" id="service-sec">
        <div class="shape-mockup service-bg-1-1" style="top: 0px; left: 0px;">
            <img src="{{ asset('themes/shop/konta/img/bg/service_bg_1.png') }}" alt="background">
        </div>
        <div class="container">

            <div class="row">
                <!-- Left Side Tab Menu -->
                <div class="col-lg-3">
                    <div class="service-tab-menu nav">
                        <button class="tab-btn active" data-bs-toggle="tab" data-bs-target="#service-tab-1">Smart Home Automation</button>
                        <button class="tab-btn" data-bs-toggle="tab" data-bs-target="#service-tab-2">Safety And Security</button>
                        <button class="tab-btn" data-bs-toggle="tab" data-bs-target="#service-tab-3">Industrial Automation</button>
                        <button class="tab-btn" data-bs-toggle="tab" data-bs-target="#service-tab-4">Planning and Design</button>
                    </div>
                </div>

                <!-- Right Side Tab Content Panes -->
                <div class="col-lg-9">
                    <div class="service-slider1 tab-content">

                        <!-- Tab 1: Smart Home Automation -->
                        <div class="tab-pane fade show active" id="service-tab-1" role="tabpanel">
                            <div class="row th-carousel" data-slide-show="3" data-lg-slide-show="2" data-md-slide-show="2" data-sm-slide-show="1">

                                <!-- Card 1: Smart Lighting -->
                                <div class="col-md-6 col-xl-4">
                                    <div class="service-card">
                                        <div class="service-card-content background-image" style="background-image: url('{{ asset('themes/shop/konta/img/service/service-card-bg-1-1.png') }}');">
                                            <div class="service-card-icon" style="margin-bottom: 20px;"><i class="fas fa-lightbulb" style="font-size: 40px; color: #ffffff;"></i></div>
                                            <h3 class="box-title"><a href="#" style="color: #ffffff;">Smart Lighting System</a></h3>
                                            <p class="service-card-text" style="color: rgba(255, 255, 255, 0.75);">Smart lights have an embedded chip to communicate wirelessly. Every light connects directly with your preferred app or ecosystem hub.</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card 2: Smart Music -->
                                <div class="col-md-6 col-xl-4">
                                    <div class="service-card">
                                        <div class="service-card-content background-image" style="background-image: url('{{ asset('themes/shop/konta/img/service/service-card-bg-1-1.png') }}');">
                                            <div class="service-card-icon" style="margin-bottom: 20px;"><i class="fas fa-music" style="font-size: 40px; color: #ffffff;"></i></div>
                                            <h3 class="box-title"><a href="#" style="color: #ffffff;">Background Music</a></h3>
                                            <p class="service-card-text" style="color: rgba(255, 255, 255, 0.75);">A modern home entertainment distribution system that handles ambient soundscapes dynamically using centralized smartphone app controls.</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card 3: Smart Curtains -->
                                <div class="col-md-6 col-xl-4">
                                    <div class="service-card">
                                        <div class="service-card-content background-image" style="background-image: url('{{ asset('themes/shop/konta/img/service/service-card-bg-1-1.png') }}');">
                                            <div class="service-card-icon" style="margin-bottom: 20px;"><i class="fas fa-sliders-h" style="font-size: 40px; color: #ffffff;"></i></div>
                                            <h3 class="box-title"><a href="#" style="color: #ffffff;">Smart Curtain System</a></h3>
                                            <p class="service-card-text" style="color: rgba(255, 255, 255, 0.75);">Equipped with specialized logic motors that manage window panels flawlessly via remote controls, automated schedules, or mobile applications.</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Tab 2: Safety And Security -->
                        <div class="tab-pane fade" id="service-tab-2" role="tabpanel">
                            <div class="row th-carousel" data-slide-show="3" data-lg-slide-show="2" data-md-slide-show="2" data-sm-slide-show="1">

                                <!-- Card 1: CCTV Surveillance -->
                                <div class="col-md-6 col-xl-4">
                                    <div class="service-card">
                                        <div class="service-card-content background-image" style="background-image: url('{{ asset('themes/shop/konta/img/service/service-card-bg-1-1.png') }}');">
                                            <div class="service-card-icon" style="margin-bottom: 20px;"><i class="fas fa-video" style="font-size: 40px; color: #ffffff;"></i></div>
                                            <h3 class="box-title"><a href="#" style="color: #ffffff;">CCTV Surveillance</a></h3>
                                            <p class="service-card-text" style="color: rgba(255, 255, 255, 0.75);">Advanced tracking innovation built for structural security, featuring advanced AI reporting, cloud backup arrays, and real-time alerts.</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card 2: Smart Alarms -->
                                <div class="col-md-6 col-xl-4">
                                    <div class="service-card">
                                        <div class="service-card-content background-image" style="background-image: url('{{ asset('themes/shop/konta/img/service/service-card-bg-1-1.png') }}');">
                                            <div class="service-card-icon" style="margin-bottom: 20px;"><i class="fas fa-bell" style="font-size: 40px; color: #ffffff;"></i></div>
                                            <h3 class="box-title"><a href="#" style="color: #ffffff;">Smart Alarm Systems</a></h3>
                                            <p class="service-card-text" style="color: rgba(255, 255, 255, 0.75);">Defend environments actively against perimeter break-ins, trespassing, and property damage using live sensors linked to modern apps.</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card 3: Smart Locks -->
                                <div class="col-md-6 col-xl-4">
                                    <div class="service-card">
                                        <div class="service-card-content background-image" style="background-image: url('{{ asset('themes/shop/konta/img/service/service-card-bg-1-1.png') }}');">
                                            <div class="service-card-icon" style="margin-bottom: 20px;"><i class="fas fa-lock" style="font-size: 40px; color: #ffffff;"></i></div>
                                            <h3 class="box-title"><a href="#" style="color: #ffffff;">Smart Door Locks</a></h3>
                                            <p class="service-card-text" style="color: rgba(255, 255, 255, 0.75);">Unlocks mechanisms smoothly when you approach home or allows immediate remote control access management wherever you go globally.</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Tab 3: Industrial Automation -->
                        <div class="tab-pane fade" id="service-tab-3" role="tabpanel">
                            <div class="row th-carousel" data-slide-show="3" data-lg-slide-show="2" data-md-slide-show="2" data-sm-slide-show="1">

                                <!-- Card 1: Central Control Gateways -->
                                <div class="col-md-6 col-xl-4">
                                    <div class="service-card">
                                        <div class="service-card-content background-image" style="background-image: url('{{ asset('themes/shop/konta/img/service/service-card-bg-1-1.png') }}');">
                                            <div class="service-card-icon" style="margin-bottom: 20px;"><i class="fas fa-microchip" style="font-size: 40px; color: #ffffff;"></i></div>
                                            <h3 class="box-title"><a href="#" style="color: #ffffff;">Central Control Gateway</a></h3>
                                            <p class="service-card-text" style="color: rgba(255, 255, 255, 0.75);">Acting as a specialized hardware link, it serves as the ultimate bridge to connect complex hardware topologies onto single, clean execution endpoints.</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card 2: Smart Temp Controls -->
                                <div class="col-md-6 col-xl-4">
                                    <div class="service-card">
                                        <div class="service-card-content background-image" style="background-image: url('{{ asset('themes/shop/konta/img/service/service-card-bg-1-1.png') }}');">
                                            <div class="service-card-icon" style="margin-bottom: 20px;"><i class="fas fa-thermometer-half" style="font-size: 40px; color: #ffffff;"></i></div>
                                            <h3 class="box-title"><a href="#" style="color: #ffffff;">Temp Control Logic</a></h3>
                                            <p class="service-card-text" style="color: rgba(255, 255, 255, 0.75);">Advanced sensor arrays eliminate temperature swings, adjusting industrial parameters to coordinate perfectly with environment baselines.</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card 3: Wireless Frameworks -->
                                <div class="col-md-6 col-xl-4">
                                    <div class="service-card">
                                        <div class="service-card-content background-image" style="background-image: url('{{ asset('themes/shop/konta/img/service/service-card-bg-1-1.png') }}');">
                                            <div class="service-card-icon" style="margin-bottom: 20px;"><i class="fas fa-wifi" style="font-size: 40px; color: #ffffff;"></i></div>
                                            <h3 class="box-title"><a href="#" style="color: #ffffff;">Wireless Automation</a></h3>
                                            <p class="service-card-text" style="color: rgba(255, 255, 255, 0.75);">Clean interconnections of heavy machinery and hardware endpoints via smart communication loops to optimize modern workflow patterns.</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Tab 4: Planning and Design -->
                        <div class="tab-pane fade" id="service-tab-4" role="tabpanel">
                            <div class="row th-carousel" data-slide-show="3" data-lg-slide-show="2" data-md-slide-show="2" data-sm-slide-show="1">

                                <!-- Card 1: Schematic Infrastructure Mapping -->
                                <div class="col-md-6 col-xl-4">
                                    <div class="service-card">
                                        <div class="service-card-content background-image" style="background-image: url('{{ asset('themes/shop/konta/img/service/service-card-bg-1-1.png') }}');">
                                            <div class="service-card-icon" style="margin-bottom: 20px;"><i class="fas fa-drafting-compass" style="font-size: 40px; color: #ffffff;"></i></div>
                                            <h3 class="box-title"><a href="#" style="color: #ffffff;">Schematic Layouts</a></h3>
                                            <p class="service-card-text" style="color: rgba(255, 255, 255, 0.75);">Detailed planning phase drafting precise signal routes, power requirements, and hardware spacing parameters before any structural deployment.</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card 2: System Integration Design -->
                                <div class="col-md-6 col-xl-4">
                                    <div class="service-card">
                                        <div class="service-card-content background-image" style="background-image: url('{{ asset('themes/shop/konta/img/service/service-card-bg-1-1.png') }}');">
                                            <div class="service-card-icon" style="margin-bottom: 20px;"><i class="fas fa-network-wired" style="font-size: 40px; color: #ffffff;"></i></div>
                                            <h3 class="box-title"><a href="#" style="color: #ffffff;">Integration Topologies</a></h3>
                                            <p class="service-card-text" style="color: rgba(255, 255, 255, 0.75);">Mapping cross-platform configurations across WiFi, Zigbee, or industrial loops to preserve device ecosystem compatibility.</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card 3: Load and Energy Audit Planning -->
                                <div class="col-md-6 col-xl-4">
                                    <div class="service-card">
                                        <div class="service-card-content background-image" style="background-image: url('{{ asset('themes/shop/konta/img/service/service-card-bg-1-1.png') }}');">
                                            <div class="service-card-icon" style="margin-bottom: 20px;"><i class="fas fa-charging-station" style="font-size: 40px; color: #ffffff;"></i></div>
                                            <h3 class="box-title"><a href="#" style="color: #ffffff;">Energy Management Audits</a></h3>
                                            <p class="service-card-text" style="color: rgba(255, 255, 255, 0.75);">Pre-installation operational assessments structured to prevent bottlenecks and map high-efficiency consumption baselines.</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== ONLINE CATALOG ===== --}}
    <section class="z-index-commonx" style="margin-bottom: 0px !important;">
        <div class="container th-container2">
            <div style="padding: 80px;position: relative;">
                <div class="row align-items-center justify-content-between">
                    <div class="col-md-8 col-sm-12">
                        <div class="title-area mb-xl-0 text-center text-xl-start mb-50">
                            <span class=" sub-title subtitle-selector">Our Online Catalog</span>
                            <h2 class="sec-title fw-semibold">Buy the Smart Device of your choice from Our Online Store</h2>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="counter-wrap4">
                            <a href="/search" class="th-btn mt-10">View Full Shop <i class="fa-regular fa-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== ONLINE CATALOG GALLERY ===== --}}
    <section class="space" id="store-catalog-sec">
        <div class="container">
            <div class="row align-items-center">

                <!-- Left Column: Catalog Graphic/Mockup -->
                <div class="col-lg-6">
                    <div class="img-box1 mb-4 mb-lg-0">
                        <img src="{{asset('themes/shop/konta/img/service/service-1-1.png')}}" alt="Automation Devices Online Catalog" class="w-100 rounded-3">
                    </div>
                </div>

                <!-- Right Column: Text Information & Lists -->
                <div class="col-lg-6">
                    <div class="ps-xl-4 ms-xl-2">

                        <!-- Title Wrapper matching standard theme styling -->
                        <div class="title-area">
                            <span class="sub-title6 title-selector justify-content-center">
                                <span class="shape left">
                                    <span class="dots"></span>
                                </span>
                                AUTOMATION DEVICES ONLINE CATALOG
                                <span class="shape right">
                                    <span class="dots"></span>
                                </span>
                            </span>
                            <h2 class="sec-title subtitle-selector">Visit Our Online Store</h2>
                        </div>

                        <p class="mb-30">Are you looking for premium components and kits to secure or smart-optimize your spaces? Explore our dynamic selection:</p>

                        <!-- Rebuilt 2-Column Checklist Layout using clean Bootstrap rows -->
                        <div class="row mb-40">
                            <div class="col-sm-6">
                                <div class="checklist style5">
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-2"> CCTV Devices</li>
                                        <li class="mb-2"> Home Alarm Kits</li>
                                        <li class="mb-2"> Smart Video Bells</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-2 mt-sm-0">
                                <div class="checklist style5">
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-2"> Electric Roller</li>
                                        <li class="mb-2"> Smart Curtain Motors</li>
                                        <li class="mb-2"> Intercom Systems</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Standard Theme Call to Action Button -->
                        <div class="btn-wrapper">
                            <a class="th-btn" href="{{ route('shop.home.store') }}">
                                Go To Store<i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ===== PROJECTS GALLERY ===== --}}
    <section style="background-color: #352A5E !important;" class="space overflow-hidden" id="project-sec">
        <div class="container">
            <div class="mb-45">
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                        <div class="title-area mb-md-0">
                            <h2 style="color:white;" class="sec-title mb-0">Projects In-Action</h2>
                        </div>
                    </div>
                    <div class="col-auto">
                        <a class="th-btn" href="https://mazzyautomations.co.za/projects/">
                            View All Gallery <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row th-carousel project-slider2" data-slide-show="4" data-ml-slide-show="3" data-lg-slide-show="3" data-md-slide-show="2" data-sm-slide-show="1" data-arrows="true">

                <div class="col-md-6 col-xl-4">
                    <div class="project-card style2">
                        <div class="project-card-img">
                            <img src="{{asset('themes/shop/konta/img/project/project1.jpg')}}" alt="CCTV Installation">
                        </div>
                        <div class="project-card-details-wrap">
                            <div class="project-card-details">
                                <h6 class="project-subtitle">Home Security</h6>
                                <h4 class="box-title"><a href="#">CCTV Installation</a></h4>
                                <p class="project-card-content">Installation of a CCTV System somewhere in Gauteng Province.</p>
                            </div>
                            <a href="{{asset('themes/shop/konta/img/project/project1.jpg')}}" class="gallery-btn popup-image">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-4">
                    <div class="project-card style2">
                        <div class="project-card-img">
                            <img src="{{asset('themes/shop/konta/img/project/door.jpg')}}" alt="Smart Door Locks">
                        </div>
                        <div class="project-card-details-wrap">
                            <div class="project-card-details">
                                <h6 class="project-subtitle">Home Security</h6>
                                <h4 class="box-title"><a href="#">Smart Door Locks</a></h4>
                                <p class="project-card-content">Smart Door Lock installation in Johannesburg</p>
                            </div>
                            <a href="{{asset('themes/shop/konta/img/project/door.jpg')}}" class="gallery-btn popup-image">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-4">
                    <div class="project-card style2">
                        <div class="project-card-img">
                            <img src="{{asset('themes/shop/konta/img/project/videointer.jpg')}}" alt="Video Intercom Door Bell">
                        </div>
                        <div class="project-card-details-wrap">
                            <div class="project-card-details">
                                <h6 class="project-subtitle">Home Security</h6>
                                <h4 class="box-title"><a href="#">Video Intercom Door Bell</a></h4>
                                <p class="project-card-content">Video Intercom Door Bell Installation in progress.</p>
                            </div>
                            <a href="{{asset('themes/shop/konta/img/project/videointer.jpg')}}" class="gallery-btn popup-image">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-4">
                    <div class="project-card style2">
                        <div class="project-card-img">
                            <img src="{{asset('themes/shop/konta/img/project/ceiling-speakers.jpg')}}" alt="Smart Ceiling Speakers">
                        </div>
                        <div class="project-card-details-wrap">
                            <div class="project-card-details">
                                <h6 class="project-subtitle">Home Security</h6>
                                <h4 class="box-title"><a href="#">Smart Ceiling Speakers</a></h4>
                                <p class="project-card-content">Smart Ceiling Speakers Installation</p>
                            </div>
                            <a href="{{asset('themes/shop/konta/img/project/ceiling-speakers.jpg')}}" class="gallery-btn popup-image">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-4">
                    <div class="project-card style2">
                        <div class="project-card-img">
                            <img src="{{asset('themes/shop/konta/img/project/project1.jpg')}}" alt="Gang Switch Systems">
                        </div>
                        <div class="project-card-details-wrap">
                            <div class="project-card-details">
                                <h6 class="project-subtitle">Home Security</h6>
                                <h4 class="box-title"><a href="#">Gang Switch Systems</a></h4>
                                <p class="project-card-content">Gang Switch System Installation in Progress</p>
                            </div>
                            <a href="{{asset('themes/shop/konta/img/project/project1.jpg')}}" class="gallery-btn popup-image">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ===== TESTIMONIALS ===== --}}
    <section class="testi-area-1 overflow-hidden space background-image arrow-wrap" data-overlay="smoke" data-opacity="9" style="background-image: url({{ asset('themes/shop/konta/img/bg/testi_bg_1.png') }}); padding-bottom: 500px;">">
        <div class="container">
            <div class="title-area text-center mb-50">
                <h2 class="sec-title">What Our Clients Say?</h2>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <!-- Pure slider initialization wrapper -->
                    <div class="th-carousel testi-slider1 slider-shadow row" data-slide-show="2" data-ml-slide-show="2" data-lg-slide-show="1" data-md-slide-show="1" data-arrows="true">

                        <!-- Testimonial 1: Emily W -->
                        <div class="col-lg-6">
                            <div class="testi-card">
                                <div class="testi-card_img">
                                    <img src="{{asset('themes/shop/konta/img/testimonial/testi_1_1-2.png')}}" alt="Emily W">
                                </div>
                                <div class="testi-card_content">
                                    <p class="testi-card_text">Mazzy Home Automation transformed my living space into a smart haven! With their intuitive system, I can effortlessly control lighting, temperature, and security from my phone. It's incredible convenience and peace of mind.</p>
                                    <div class="testi-card_bottom">
                                        <div>
                                            <h3 class="testi-card_name">Emily W</h3>
                                            <span class="testi-card_desig">Homeowner</span>
                                        </div>
                                        <div class="testi-card_icon">
                                            <img src="{{asset('themes/shop/konta/img/icon/testi-quote.svg')}}" alt="quote">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Testimonial 2: David and Sarah -->
                        <div class="col-lg-6">
                            <div class="testi-card">
                                <div class="testi-card_img">
                                    <img src="{{asset('themes/shop/konta/img/testimonial/testi_1_1.png')}}" alt="David and Sarah">
                                </div>
                                <div class="testi-card_content">
                                    <p class="testi-card_text">We were amazed by the energy savings after installing Mazzy's automation system. Our utility bills dropped by 40%! The eco-friendly features and automated energy optimization have made a significant impact.</p>
                                    <div class="testi-card_bottom">
                                        <div>
                                            <h3 class="testi-card_name">David and Sarah</h3>
                                            <span class="testi-card_desig">Homeowners</span>
                                        </div>
                                        <div class="testi-card_icon">
                                            <img src="assets/img/icon/testi-quote.svg" alt="quote">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Testimonial 3: Rachel T -->
                        <div class="col-lg-6">
                            <div class="testi-card">
                                <div class="testi-card_img">
                                    <img src="{{asset('themes/shop/konta/img/testimonial/testi_1_1-1.png')}}" alt="Rachel T">
                                </div>
                                <div class="testi-card_content">
                                    <p class="testi-card_text">Mazzy's home automation system gives us unparalleled security. The seamless integration of cameras, door sensors, and smart locks ensures our family's safety. We sleep better knowing our home is protected.</p>
                                    <div class="testi-card_bottom">
                                        <div>
                                            <h3 class="testi-card_name">Rachel T</h3>
                                            <span class="testi-card_desig">Parent of two</span>
                                        </div>
                                        <div class="testi-card_icon">
                                            <img src="assets/img/icon/testi-quote.svg" alt="quote">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== CTA SECTION ===== --}}
    <section class="cta-area-1 space background-image" data-overlay="dark" data-opacity="8" style="background-image: url({{ asset('themes/shop/konta/img/bg/cta_bg_1.png') }});">
        <div class="container">
            <div class="container" id="contact-sec" ><div class="cta-area-1" ><div class="row g-0 align-items-center" ><div class="col-xl-5" ><div class="cta-wrap title-area mb-0 bg-theme" ><span class="sub-title text-white title-selector"> Call To Action</span><h2 class="sec-title text-white subtitle-selector">Do you wish to Automate your Home or Workplace ? Let’s Talk Now !</h2><p class="sec-text text-white desc-selector">An increasing number of residents are automating their homes so as to make their life easier and also as a way to improve their security systems.</p><div class="cta-link-wrap mb-40" ><div class="cta-link" >
                                        <div class="cta-link-icon" >
                                            <i class="fas fa-phone"></i>
                                        </div>
                                        <div >
                                            <p>Call Us Anytime:</p>
                                            <a class="cta-single-link" href="tel:+27787972186" >+27787972186</a>
                                        </div>
                                    </div>
                                    <div class="cta-link" >
                                        <div class="cta-link-icon" >
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                        <div >
                                            <p>Email Us:</p>
                                            <a class="cta-single-link" href="mailto:support@mazzyautomations.co.za" >support@mazzyautomations.co.za</a>
                                        </div>
                                    </div></div><a href="https://mazzyautomations.co.za/about-us/" class="th-btn style6" >More About us<i class="fas fa-arrow-right ms-1"></i></a></div></div><div class="col-xl-7" ><div class="contact-form-wrap" >
                        <h2 class="title h4 text-center">Request A Quote</h2>
                        <div class="contact-form ">

                            @if (session('success'))
                                <div class="alert alert-success mb-3">{{ session('success') }}</div>
                            @endif

                            <x-shop::form :action="route('shop.home.quote.send')">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group style-border mb-20">
                                            <x-shop::form.control-group.control
                                                type="text"
                                                class="form-control"
                                                name="name"
                                                rules="required"
                                                label="Your Name"
                                                placeholder="Your Name*"
                                                :value="old('name')"
                                            />
                                            <x-shop::form.control-group.error control-name="name" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group style-border mb-20">
                                            <x-shop::form.control-group.control
                                                type="email"
                                                class="form-control"
                                                name="email"
                                                rules="required|email"
                                                label="Email Address"
                                                placeholder="Email Address*"
                                                :value="old('email')"
                                            />
                                            <x-shop::form.control-group.error control-name="email" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group style-border mb-20">
                                            <select class="form-control" name="subject">
                                                <option value="">Select Quote Type</option>
                                                <option value="Design and Planning Quote" @selected(old('subject') == 'Design and Planning Quote')>Design and Planning Quote</option>
                                                <option value="Home Automation Quote" @selected(old('subject') == 'Home Automation Quote')>Home Automation Quote</option>
                                                <option value="Industrial Automation Quote" @selected(old('subject') == 'Industrial Automation Quote')>Industrial Automation Quote</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group style-border mb-20">
                                            <x-shop::form.control-group.control
                                                type="text"
                                                class="form-control"
                                                name="phone"
                                                label="Phone Number"
                                                placeholder="Phone Number*"
                                                :value="old('phone')"
                                            />
                                            <x-shop::form.control-group.error control-name="phone" />
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group style-border mb-20">
                                            <x-shop::form.control-group.control
                                                type="textarea"
                                                class="form-control"
                                                name="message"
                                                rules="required"
                                                label="Message"
                                                placeholder="Write Your Message*"
                                                rows="6"
                                            />
                                            <x-shop::form.control-group.error control-name="message" />
                                        </div>
                                    </div>
                                    <div class="form-btn col-12">
                                        <button type="submit" class="th-btn">
                                            Submit Message <i class="fas fa-paper-plane ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </x-shop::form>
</div></div></div></div></div></div>
        </div>
    </section>

</x-shop::layouts>
