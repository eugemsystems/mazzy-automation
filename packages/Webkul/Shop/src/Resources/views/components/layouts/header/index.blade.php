@php
    $solutionsPages = \Webkul\CMS\Models\Page::where('show_in_solutions', true)
        ->whereNull('parent_id')
        ->with(['children'])
        ->orderBy('sort_order')
        ->orderBy('id')
        ->get();
    $hasSolutionsPages = $solutionsPages->count() > 0;
    $isSolutionsActive = request()->routeIs('shop.home.solutions')
        || request()->routeIs('shop.home.planning_and_design')
        || request()->routeIs('shop.cms.page.root');
@endphp

{!! view_render_event('bagisto.shop.layout.header.before') !!}

<header class="th-header header-layout1">

    {{-- Top Bar --}}
    <div class="header-top" data-bg-src="{{ asset('themes/shop/konta/img/bg/header-top1-bg.png') }}">
        <div class="container th-container2">
            <div class="row justify-content-center justify-content-lg-between align-items-center gy-2">
                <div class="col-auto d-none d-lg-block">
                    <div class="header-links">
                        <ul>
                            <li><i class="far fa-phone"></i><a href="tel:{{ config('company.phone.mobile') }}">{{ config('company.phone.mobile') }}</a></li>
                            <li class="d-none d-xl-inline-block"><i class="far fa-phone"></i><a href="tel:{{ config('company.phone.telephone') }}">{{ config('company.phone.telephone') }}</a></li>
                            <li class="d-none d-xl-inline-block"><i class="far fa-envelope"></i><a href="mailto:{{ config('company.email') }}">{{ config('company.email') }}</a></li>
                            <li><i class="far fa-location-dot"></i>{{ config('company.address') }}</li>
                        </ul>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="header-links header-right">
                        <ul>
                            <li>
                                <div class="header-social">
                                    <a href="https://www.facebook.com/profile.php?id=100076614051325" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                    <a href="https://twitter.com/mazzy" target="_blank"><i class="fab fa-twitter"></i></a>
                                    <a href="https://www.linkedin.com/mazzy" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                                    <a href="https://m.youtube.com/channel/UCV56pyzWYD6xM_CEEyGfzew" target="_blank"><i class="fab fa-youtube"></i></a>
                                    <a href="https://www.instagram.com/invites/contact/?i=6lyiuxkdo7y6&utm_content=nfh45nw" target="_blank"><i class="fab fa-instagram"></i></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Sticky Wrapper --}}
    <div class="sticky-wrapper">
        <div class="menu-area">
            <div class="container th-container2">
                <div class="row align-items-center justify-content-between" style="flex-wrap:nowrap;">

                    {{-- Logo --}}
                    <div class="col-auto">
                        <div class="header-logo">
                            <a href="{{ route('shop.home.index') }}">
                                <img
                                    src="{{ core()->getCurrentChannel()->logo_url ?? asset('themes/shop/konta/img/logo.svg') }}"
                                    alt="Mazzy Automations"
                                    style="max-height:55px;"
                                >
                            </a>
                        </div>
                    </div>

                    {{-- Contact Info (hidden when sticky) --}}
                    <div class="col-auto d-none d-lg-block sticy-d-none">
                        <div class="header-middle">
                            <div class="header-link">
                                <i class="fas fa-phone"></i>
                                <div>
                                    <p>Call Us Any Time:</p>
                                    <a class="header-single-link" href="tel:{{ config('company.phone.mobile') }}">{{ config('company.phone.mobile') }}</a>
                                </div>
                            </div>
                            <div class="header-link">
                                <i class="fas fa-envelope"></i>
                                <div>
                                    <p>Email Us:</p>
                                    <a class="header-single-link" href="mailto:{{ config('company.email') }}">{{ config('company.email') }}</a>
                                </div>
                            </div>
                            <div class="header-link d-xl-inline-flex d-none">
                                <i class="fas fa-clock"></i>
                                <div>
                                    <p>Working Time:</p>
                                    <span class="header-single-link">Mon - Fri: {{ config('company.hours.weekdays') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Mobile Nav (shown when sticky on desktop) --}}
                    <div class="col-auto sticy-d-block">
                        <nav class="main-menu d-none d-lg-inline-block">
                            <ul>
                                <li class="{{ request()->routeIs('shop.home.index') ? 'active' : '' }}">
                                    <a href="{{ route('shop.home.index') }}">Home</a>
                                </li>
                                <li class="{{ request()->routeIs('shop.home.about_us') ? 'active' : '' }}">
                                    <a href="{{ route('shop.home.about_us') }}">Who We Are</a>
                                </li>
                                @if($hasSolutionsPages)
                                    <li class="menu-item-has-children {{ $isSolutionsActive ? 'active' : '' }}">
                                        <a href="#">Solutions</a>
                                        <ul class="sub-menu">
                                            @foreach($solutionsPages as $sPage)
                                                @if($sPage->children->count() > 0)
                                                    <li class="menu-item-has-children">
                                                        <a href="{{ $sPage->url_key ? route('shop.cms.page.root', $sPage->url_key) : '#' }}">{{ $sPage->menu_label ?: $sPage->page_title }}</a>
                                                        <ul class="sub-menu">
                                                            @foreach($sPage->children as $child)
                                                                <li><a href="{{ route('shop.cms.page.root', $child->url_key) }}">{{ $child->menu_label ?: $child->page_title }}</a></li>
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                @else
                                                    <li><a href="{{ route('shop.cms.page.root', $sPage->url_key) }}">{{ $sPage->menu_label ?: $sPage->page_title }}</a></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                @else
                                    <li class="menu-item-has-children {{ $isSolutionsActive ? 'active' : '' }}">
                                        <a href="#">Solutions</a>
                                        <ul class="sub-menu">
                                            <li><a href="{{ route('shop.home.planning_and_design') }}">Design & Planning</a></li>
                                            <li class="menu-item-has-children">
                                                <a href="#">Home Automation</a>
                                                <ul class="sub-menu">
                                                    <li><a href="{{ route('shop.home.solutions', 'smart-lighting-systems') }}">Smart Lighting Systems</a></li>
                                                    <li><a href="{{ route('shop.home.solutions', 'smart-door-lock-systems') }}">Smart Door Lock Systems</a></li>
                                                    <li><a href="{{ route('shop.home.solutions', 'smart-curtain-systems') }}">Smart Curtain Systems</a></li>
                                                    <li><a href="{{ route('shop.home.solutions', 'smart-hotel-solutions') }}">Smart Hotel Solutions</a></li>
                                                    <li><a href="{{ route('shop.home.solutions', 'smart-gate-systems') }}">Smart Gate Systems</a></li>
                                                    <li><a href="{{ route('shop.home.solutions', 'smart-controlled-light-strips') }}">Smart Controlled Light Strips</a></li>
                                                    <li><a href="{{ route('shop.home.solutions', 'lighting-accessories') }}">Lighting Accessories</a></li>
                                                </ul>
                                            </li>
                                            <li class="menu-item-has-children">
                                                <a href="#">Industrial Automation</a>
                                                <ul class="sub-menu">
                                                    <li><a href="{{ route('shop.home.solutions', 'ai-systems') }}">AI Systems</a></li>
                                                    <li><a href="{{ route('shop.home.solutions', 'robotic-systems') }}">Robotic Systems</a></li>
                                                    <li><a href="{{ route('shop.home.solutions', 'dcs-systems') }}">DCS Systems</a></li>
                                                    <li><a href="{{ route('shop.home.solutions', 'servo-systems') }}">Servo Systems</a></li>
                                                    <li><a href="{{ route('shop.home.solutions', 'iot-systems') }}">IOT Systems</a></li>
                                                    <li><a href="{{ route('shop.home.solutions', 'scada-systems') }}">SCADA Systems</a></li>
                                                </ul>
                                            </li>
                                            <li class="menu-item-has-children">
                                                <a href="#">Smart Security Systems</a>
                                                <ul class="sub-menu">
                                                    <li><a href="{{ route('shop.home.solutions', 'smart-security-sensors') }}">Smart Security Sensors</a></li>
                                                    <li><a href="{{ route('shop.home.solutions', 'alarm-and-access-control') }}">Alarm and Access Control Systems</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="{{ route('shop.home.solutions', 'smart-monitoring-and-control') }}">Smart Monitoring & Control</a></li>
                                            <li><a href="{{ route('shop.home.solutions', 'smart-entertainment-systems') }}">Smart Entertainment Systems</a></li>
                                        </ul>
                                    </li>
                                @endif
                                <li class="{{ request()->routeIs('shop.home.our_work') ? 'active' : '' }}">
                                    <a href="{{ route('shop.home.our_work') }}">Our Work</a>
                                </li>
                                <li class="{{ request()->routeIs('shop.home.projects') ? 'active' : '' }}">
                                    <a href="{{ route('shop.home.projects') }}">Projects</a>
                                </li>
                                <li class="menu-item-has-children {{ request()->routeIs('shop.home.gallery') ? 'active' : '' }}">
                                    <a href="#">Media</a>
                                    <ul class="sub-menu">
                                        <li><a href="{{ route('shop.home.gallery') }}">Gallery</a></li>
                                    </ul>
                                </li>
                                <li class="{{ request()->routeIs('shop.home.contact_us') ? 'active' : '' }}">
                                    <a href="{{ route('shop.home.contact_us') }}">Contact</a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                    {{-- Mobile Toggle --}}
                    <div class="col-auto d-lg-none">
                        <button type="button" class="th-menu-toggle d-block d-lg-none"><i class="far fa-bars"></i></button>
                    </div>

                </div>

                {{-- Main Nav Bar (always visible on desktop) --}}
                <div style="border-bottom: solid white 1px;border-left: solid white 1px;" class="main-menu-area">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <nav class="main-menu d-none d-lg-inline-block">
                                <ul>
                                    <li class="{{ request()->routeIs('shop.home.index') ? 'active' : '' }}">
                                        <a href="{{ route('shop.home.index') }}">Home</a>
                                    </li>
                                    <li class="{{ request()->routeIs('shop.home.about_us') ? 'active' : '' }}">
                                        <a href="{{ route('shop.home.about_us') }}">Who We Are</a>
                                    </li>
                                    @if($hasSolutionsPages)
                                        <li class="menu-item-has-children {{ $isSolutionsActive ? 'active' : '' }}">
                                            <a href="#">Solutions</a>
                                            <ul class="sub-menu">
                                                @foreach($solutionsPages as $sPage)
                                                    @if($sPage->children->count() > 0)
                                                        <li class="menu-item-has-children">
                                                            <a href="{{ $sPage->url_key ? route('shop.cms.page.root', $sPage->url_key) : '#' }}">{{ $sPage->menu_label ?: $sPage->page_title }}</a>
                                                            <ul class="sub-menu">
                                                                @foreach($sPage->children as $child)
                                                                    <li><a href="{{ route('shop.cms.page.root', $child->url_key) }}">{{ $child->menu_label ?: $child->page_title }}</a></li>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    @else
                                                        <li><a href="{{ route('shop.cms.page.root', $sPage->url_key) }}">{{ $sPage->menu_label ?: $sPage->page_title }}</a></li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </li>
                                    @else
                                        <li class="menu-item-has-children {{ $isSolutionsActive ? 'active' : '' }}">
                                            <a href="#">Solutions</a>
                                            <ul class="sub-menu">
                                                <li><a href="{{ route('shop.home.planning_and_design') }}">Design & Planning</a></li>
                                                <li class="menu-item-has-children">
                                                    <a href="#">Home Automation</a>
                                                    <ul class="sub-menu">
                                                        <li><a href="{{ route('shop.home.lutron_smart_control') }}">Lutron Smart Control</a></li>
                                                        <li><a href="{{ route('shop.home.wiim_home_audio') }}">WiiM Home Audio</a></li>
                                                        <li><a href="{{ route('shop.home.denon_multi_room_audio') }}">Denon Multi-room Audio</a></li>
                                                        <li><a href="{{ route('shop.home.polk_audio_sound_system') }}">Polk Audio Sound System</a></li>
                                                        <li><a href="{{ route('shop.home.solutions', 'smart-lighting-systems') }}">Smart Lighting Systems</a></li>
                                                        <li><a href="{{ route('shop.home.solutions', 'smart-door-lock-systems') }}">Smart Door Lock Systems</a></li>
                                                        <li><a href="{{ route('shop.home.solutions', 'smart-curtain-systems') }}">Smart Curtain Systems</a></li>
                                                        <li><a href="{{ route('shop.home.solutions', 'smart-hotel-solutions') }}">Smart Hotel Solutions</a></li>
                                                        <li><a href="{{ route('shop.home.solutions', 'smart-gate-systems') }}">Smart Gate Systems</a></li>
                                                        <li><a href="{{ route('shop.home.solutions', 'smart-controlled-light-strips') }}">Smart Controlled Light Strips</a></li>
                                                        <li><a href="{{ route('shop.home.solutions', 'lighting-accessories') }}">Lighting Accessories</a></li>
                                                    </ul>
                                                </li>
                                                <li class="menu-item-has-children">
                                                    <a href="#">Industrial Automation</a>
                                                    <ul class="sub-menu">
                                                        <li><a href="{{ route('shop.home.solutions', 'ai-systems') }}">AI Systems</a></li>
                                                        <li><a href="{{ route('shop.home.solutions', 'robotic-systems') }}">Robotic Systems</a></li>
                                                        <li><a href="{{ route('shop.home.solutions', 'dcs-systems') }}">DCS Systems</a></li>
                                                        <li><a href="{{ route('shop.home.solutions', 'servo-systems') }}">Servo Systems</a></li>
                                                        <li><a href="{{ route('shop.home.solutions', 'iot-systems') }}">IOT Systems</a></li>
                                                        <li><a href="{{ route('shop.home.solutions', 'scada-systems') }}">SCADA Systems</a></li>
                                                    </ul>
                                                </li>
                                                <li class="menu-item-has-children">
                                                    <a href="#">Smart Security Systems</a>
                                                    <ul class="sub-menu">
                                                        <li><a href="{{ route('shop.home.solutions', 'smart-security-sensors') }}">Smart Security Sensors</a></li>
                                                        <li><a href="{{ route('shop.home.solutions', 'alarm-and-access-control') }}">Alarm and Access Control Systems</a></li>
                                                    </ul>
                                                </li>
                                                <li><a href="{{ route('shop.home.solutions', 'smart-monitoring-and-control') }}">Smart Monitoring & Control</a></li>
                                                <li><a href="{{ route('shop.home.solutions', 'smart-entertainment-systems') }}">Smart Entertainment Systems</a></li>
                                            </ul>
                                        </li>
                                    @endif
                                    <li class="{{ request()->routeIs('shop.home.our_work') ? 'active' : '' }}">
                                        <a href="{{ route('shop.home.our_work') }}">Our Work</a>
                                    </li>
                                    <li class="{{ request()->routeIs('shop.home.projects') ? 'active' : '' }}">
                                        <a href="{{ route('shop.home.projects') }}">Projects</a>
                                    </li>
                                    <li class="menu-item-has-children {{ request()->routeIs('shop.home.gallery') ? 'active' : '' }}">
                                        <a href="#">Media</a>
                                        <ul class="sub-menu">
                                            <li><a href="{{ route('shop.home.gallery') }}">Gallery</a></li>
                                        </ul>
                                    </li>
                                    <li class="{{ request()->routeIs('shop.home.contact_us') ? 'active' : '' }}">
                                        <a href="{{ route('shop.home.contact_us') }}">Contact</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>

                        <div class="col-auto d-none d-lg-block">
                            <div class="header-button">
                                <button type="button" class="icon-btn style2 searchBoxToggler"><i class="far fa-search"></i></button>
                                <button type="button" class="icon-btn style2 sideMenuToggler"><i class="fas fa-grid"></i></button>

                                @if(request()->routeIs('shop.home.store'))
                                    {{-- Bagisto Cart --}}
                                    @if(core()->getConfigData('sales.checkout.shopping_cart.cart_page'))
                                        @include('shop::checkout.cart.mini-cart')
                                    @endif

                                    {{-- Account --}}
                                    @auth('customer')
                                        <a href="{{ route('shop.customers.account.profile.index') }}" class="icon-btn style2" title="My Account">
                                            <i class="far fa-user"></i>
                                        </a>
                                    @else
                                        <a href="{{ route('shop.customer.session.index') }}" class="icon-btn style2" title="Login">
                                            <i class="far fa-user"></i>
                                        </a>
                                    @endauth
                                @endif

                                <a style="background-color: #F0A637 !important;" href="{{ route('shop.home.store') }}" class="th-btn style8 ml-25">Visit Shop <i class="fas fa-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="logo-bg"></div>
        </div>
    </div>

</header>

{!! view_render_event('bagisto.shop.layout.header.after') !!}
