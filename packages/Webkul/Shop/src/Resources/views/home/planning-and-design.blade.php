<x-shop::layouts>
    <x-slot:title>Design Plan Packages - Mazzy Automations</x-slot>

    {{-- Breadcrumb --}}
    <div class="breadcumb-wrapper" data-bg-src="{{ asset('themes/shop/konta/img/bg/breadcumb-bg.jpg') }}">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Design Plan Packages</h1>
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('shop.home.index') }}">Home</a></li>
                    <li>Solutions</li>
                    <li>Design Plan Packages</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Intro Section --}}
    <div class="space-top space-extra-bottom">
        <div class="container">
            <div class="row justify-content-center mb-60">
                <div class="col-lg-8 text-center">
                    <div class="title-area">
                        <span class="sub-title"><i class="fas fa-drafting-compass"></i> Planning & Design</span>
                        <h2 class="sec-title">Choose Your Design Package</h2>
                        <p class="sec-text">Before we install anything, we design it. Our professional design and planning packages ensure your automation system is perfectly conceived, documented, and costed — setting the foundation for a flawless installation.</p>
                    </div>
                </div>
            </div>

            {{-- What's Included Info --}}
            <div class="row gy-4 mb-70">
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <div class="feature-card_icon mx-auto"><i class="fas fa-ruler-combined"></i></div>
                        <h5 class="feature-card_title">Site Survey</h5>
                        <p>Our engineers conduct a thorough on-site assessment of your space to understand the scope, infrastructure, and requirements of your project.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <div class="feature-card_icon mx-auto"><i class="fas fa-file-alt"></i></div>
                        <h5 class="feature-card_title">Technical Design</h5>
                        <p>We produce detailed floor plans, wiring diagrams, device schedules, and system architecture drawings for your automation solution.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <div class="feature-card_icon mx-auto"><i class="fas fa-calculator"></i></div>
                        <h5 class="feature-card_title">Detailed Quotation</h5>
                        <p>Receive a fully itemized bill of materials, labour costs, and project timeline so you know exactly what to expect before committing.</p>
                    </div>
                </div>
            </div>

            {{-- Pricing Plans --}}
            <div class="row justify-content-center mb-50">
                <div class="col-lg-8 text-center">
                    <div class="title-area">
                        <h2 class="sec-title">Design Package Pricing</h2>
                        <p>All design packages include a site survey and can be credited against your installation cost. Prices exclude VAT.</p>
                    </div>
                </div>
            </div>

            <div class="row gy-4 justify-content-center">
                {{-- Basic Package --}}
                <div class="col-md-6 col-xl-4">
                    <div class="price-card">
                        <div class="price-card_top">
                            <h3 class="price-card_title">Basic</h3>
                            <div class="price-card_price">
                                <span class="price-card_currency">R</span>
                                <span class="price-card_amount">1,500</span>
                                <span class="price-card_period">/ package</span>
                            </div>
                            <p class="price-card_subtitle">Minimum 3 rooms &mdash; ideal for small households</p>
                        </div>
                        <div class="price-card_content">
                            <ul class="price-card_features">
                                <li class="active"><i class="fas fa-check"></i> Solution goals definition</li>
                                <li class="active"><i class="fas fa-check"></i> Budget establishment</li>
                                <li class="active"><i class="fas fa-check"></i> Interface architecture</li>
                                <li class="active"><i class="fas fa-check"></i> Sensing requirements</li>
                                <li class="active"><i class="fas fa-check"></i> Security level definition</li>
                                <li class="active"><i class="fas fa-check"></i> Automation depth</li>
                                <li class="active"><i class="fas fa-check"></i> Room control unit requirements</li>
                                <li class="active"><i class="fas fa-check"></i> Central control unit planning</li>
                            </ul>
                            <a href="{{ route('shop.home.contact_us') }}" class="th-btn w-100 text-center mt-30">Get Started <i class="fas fa-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                </div>

                {{-- Standard Package --}}
                <div class="col-md-6 col-xl-4">
                    <div class="price-card active">
                        <div class="price-card_badge">Most Popular</div>
                        <div class="price-card_top">
                            <h3 class="price-card_title">Standard</h3>
                            <div class="price-card_price">
                                <span class="price-card_currency">R</span>
                                <span class="price-card_amount">2,500</span>
                                <span class="price-card_period">/ package</span>
                            </div>
                            <p class="price-card_subtitle">Minimum 6 rooms &mdash; designed for medium households</p>
                        </div>
                        <div class="price-card_content">
                            <ul class="price-card_features">
                                <li class="active"><i class="fas fa-check"></i> Solution goals definition</li>
                                <li class="active"><i class="fas fa-check"></i> Budget establishment</li>
                                <li class="active"><i class="fas fa-check"></i> Interface architecture</li>
                                <li class="active"><i class="fas fa-check"></i> Sensing requirements</li>
                                <li class="active"><i class="fas fa-check"></i> Security level definition</li>
                                <li class="active"><i class="fas fa-check"></i> Automation depth</li>
                                <li class="active"><i class="fas fa-check"></i> Room control unit requirements</li>
                                <li class="active"><i class="fas fa-check"></i> Central control unit planning</li>
                            </ul>
                            <a href="{{ route('shop.home.contact_us') }}" class="th-btn w-100 text-center mt-30">Get Started <i class="fas fa-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                </div>

                {{-- Premium Package --}}
                <div class="col-md-6 col-xl-4">
                    <div class="price-card">
                        <div class="price-card_top">
                            <h3 class="price-card_title">Premium</h3>
                            <div class="price-card_price">
                                <span class="price-card_currency">R</span>
                                <span class="price-card_amount">5,000</span>
                                <span class="price-card_period">/ package</span>
                            </div>
                            <p class="price-card_subtitle">Minimum 12 rooms &mdash; for large households</p>
                        </div>
                        <div class="price-card_content">
                            <ul class="price-card_features">
                                <li class="active"><i class="fas fa-check"></i> Solution goals definition</li>
                                <li class="active"><i class="fas fa-check"></i> Budget establishment</li>
                                <li class="active"><i class="fas fa-check"></i> Interface architecture</li>
                                <li class="active"><i class="fas fa-check"></i> Sensing requirements</li>
                                <li class="active"><i class="fas fa-check"></i> Security level definition</li>
                                <li class="active"><i class="fas fa-check"></i> Automation depth</li>
                                <li class="active"><i class="fas fa-check"></i> Room control unit requirements</li>
                                <li class="active"><i class="fas fa-check"></i> Central control unit planning</li>
                            </ul>
                            <a href="{{ route('shop.home.contact_us') }}" class="th-btn w-100 text-center mt-30">Get Started <i class="fas fa-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Note --}}
            <div class="row justify-content-center mt-40">
                <div class="col-lg-8">
                    <div class="bg-smoke p-4 rounded text-center">
                        <i class="fas fa-info-circle text-theme fa-2x mb-3"></i>
                        <h5>Design Fees Are Credited Against Installation</h5>
                        <p class="mb-0">When you proceed with a full installation from Mazzy Automations, the cost of your design package is fully credited against your installation invoice. You only pay for the design if you choose a different installer.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Design Process --}}
    <div class="bg-smoke space-top space-extra-bottom">
        <div class="container">
            <div class="row justify-content-center mb-50">
                <div class="col-lg-8 text-center">
                    <div class="title-area">
                        <span class="sub-title"><i class="fas fa-list-ol"></i> Our Process</span>
                        <h2 class="sec-title">How The Design Process Works</h2>
                    </div>
                </div>
            </div>
            <div class="row gy-4">
                <div class="col-md-6 col-xl-3">
                    <div class="process-card text-center">
                        <div class="process-card_number">01</div>
                        <div class="process-card_icon"><i class="fas fa-phone-alt"></i></div>
                        <h5 class="process-card_title">Initial Consultation</h5>
                        <p>Contact us to discuss your project goals, budget, and requirements. We'll recommend the right design package for your needs.</p>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="process-card text-center">
                        <div class="process-card_number">02</div>
                        <div class="process-card_icon"><i class="fas fa-search-location"></i></div>
                        <h5 class="process-card_title">Site Survey</h5>
                        <p>Our engineers visit your property to assess the space, existing infrastructure, and identify the best approach for your automation system.</p>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="process-card text-center">
                        <div class="process-card_number">03</div>
                        <div class="process-card_icon"><i class="fas fa-pencil-ruler"></i></div>
                        <h5 class="process-card_title">Design & Documentation</h5>
                        <p>We produce all technical drawings, device schedules, and specifications. You'll receive a comprehensive design package within 5–7 business days.</p>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="process-card text-center">
                        <div class="process-card_number">04</div>
                        <div class="process-card_icon"><i class="fas fa-rocket"></i></div>
                        <h5 class="process-card_title">Installation</h5>
                        <p>With an approved design in hand, our installation team executes the project efficiently — knowing exactly what to do from day one.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- CTA --}}
    <div class="space-top space-extra-bottom">
        <div class="container">
            <div class="row align-items-center justify-content-between gy-4">
                <div class="col-lg-7">
                    <div class="title-area">
                        <span class="sub-title"><i class="fas fa-comments"></i> Let's Talk</span>
                        <h2 class="sec-title">Not Sure Which Package You Need?</h2>
                        <p>Our team is happy to advise you on the right design package based on your project scope and budget. Contact us today for a free preliminary discussion.</p>
                    </div>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('shop.home.contact_us') }}" class="th-btn">Get Free Advice <i class="fas fa-arrow-right ms-2"></i></a>
                        <a href="tel:+27787972186" class="th-btn style2">Call +27 787 972 186 <i class="fas fa-phone ms-2"></i></a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="bg-theme p-4 rounded text-white text-center">
                        <i class="fas fa-clock fa-3x mb-3"></i>
                        <h5 class="text-white">Office Hours</h5>
                        <p class="text-white opacity-75 mb-0">Mon – Sat: 8:00am – 5:00pm<br>Sunday: Closed</p>
                        <hr class="border-white opacity-25 my-3">
                        <a href="mailto:info@mazzyautomations.co.za" class="text-white">info@mazzyautomations.co.za</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-shop::layouts>
