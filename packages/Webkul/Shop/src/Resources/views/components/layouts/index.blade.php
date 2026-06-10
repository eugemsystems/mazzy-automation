@props([
    'hasHeader'  => true,
    'hasFeature' => false,
    'hasFooter'  => true,
])

@php
    $isStorePage = request()->is('store') || request()->is('store/*');
@endphp

<!DOCTYPE html>
<html class="no-js" lang="{{ app()->getLocale() }}" dir="{{ core()->getCurrentLocale()->direction }}">
<head>
    {!! view_render_event('bagisto.shop.layout.head.before') !!}

    <title>{{ $title ?? 'Mazzy Automations' }}</title>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="content-language" content="{{ app()->getLocale() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="base-url" content="{{ url()->to('/') }}">
    <meta name="currency" content="{{ core()->getCurrentCurrency()->toJson() }}">
    <meta name="generator" content="Bagisto">

    @stack('meta')

    <link rel="icon" sizes="16x16" href="{{ asset('themes/shop/konta/img/favicons/favicon-16x16.png') }}" />

    {{-- Bagisto Vite: Tailwind CSS + Vue.js (always loaded) --}}
    @bagistoVite(['src/Resources/assets/css/app.css', 'src/Resources/assets/js/app.js'])

    {{-- Shared: fonts + Konta theme CSS loaded on ALL pages --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300&family=Public+Sans:wght@100;200;300;400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('themes/shop/konta/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/shop/konta/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/shop/konta/css/style.css') }}">

    @if ($isStorePage)
        <style>
            /* ============================================================
               STORE PAGE — scoped under .store-page to avoid leaking
               ============================================================ */

            /* Override Konta CSS variables with store theme color */
            body.store-page { --theme-color: #332a5e; --title-color: #332a5e; }

            /* Base */
            body.store-page {
                font-family: 'Inter', 'Public Sans', sans-serif;
                background: #f4f6fb;
                font-size: 14px;
                color: #1e293b;
            }

            /* Page wrapper — boxes all store content to 1400 px */
            .mz-page-wrapper {
                max-width: 1400px;
                margin: 0 auto;
                background: #f4f6fb;
                /*box-shadow: 0 0 40px rgba(15,23,42,.12);*/
            }

            /* Font Awesome — align with Konta FA6 */
            .fa, .fas, .far, .fal, .fat, .fa-solid, .fa-regular, .fa-light, .fa-thin { font-family: "Font Awesome 6 Pro" !important; }
            .fab, .fa-brands { font-family: "Font Awesome 6 Brands" !important; }
            .fad, .fa-duotone { font-family: "Font Awesome 6 Duotone" !important; }

            /* ---- Store component CSS (mz-dropdown, mz-collapse) ---- */
            .mz-dropdown { position: relative; display: inline-block; }
            .mz-dropdown-menu {
                position: absolute; z-index: 1050; display: none; min-width: 180px;
                background: #fff; border: 1px solid rgba(0,0,0,.08);
                border-radius: 10px; box-shadow: 0 8px 28px rgba(15,23,42,.13);
                padding: 6px 0; font-size: 13.5px; top: calc(100% + 6px); left: 0;
            }
            .mz-dropdown-menu.end { right: 0; left: auto; }
            .mz-dropdown-menu.show { display: block; }
            /* CSS hover — works without JS, covers desktop */
            @media (hover: hover) and (pointer: fine) {
                .mz-dropdown:hover > .mz-dropdown-menu { display: block; }
            }
            .mz-dropdown-item {
                display: flex; align-items: center; gap: 8px;
                padding: 9px 16px; color: #334155; text-decoration: none;
                transition: background .15s, color .15s; white-space: nowrap;
            }
            .mz-dropdown-item:hover { background: #f0edf8; color: #332a5e; }
            .mz-dropdown-item.danger { color: #dc2626; }
            .mz-dropdown-item.danger:hover { background: #fff5f5; color: #b91c1c; }
            .mz-dropdown-divider { border-top: 1px solid #f1f5f9; margin: 4px 0; }

            .mz-collapse:not(.show) { display: none; }

            /* ---- Store Header ---- */
            .mz-header { position: sticky; top: 0; z-index: 1000; }

            /* Top bar */
            .mz-topbar {
                background: #2a2250; color: rgba(255,255,255,.8);
                font-size: 12px; padding: 6px 0; line-height: 1.4;
            }
            .mz-topbar-inner {
                padding: 0 24px;
                display: flex; align-items: center; justify-content: space-between; gap: 12px;
            }
            .mz-topbar-msg { display: flex; align-items: center; gap: 6px; }
            .mz-topbar-msg i { color: #FF9923; }
            .mz-topbar-right { display: flex; align-items: center; gap: 16px; }
            .mz-social-links { display: flex; align-items: center; gap: 6px; }
            .mz-social-links a {
                display: inline-flex; align-items: center; justify-content: center;
                width: 22px; height: 22px; border-radius: 50%;
                border: 1px solid rgba(255,255,255,.2); color: rgba(255,255,255,.7);
                font-size: 10px; text-decoration: none; transition: all .2s;
            }
            .mz-social-links a:hover { background: #FF9923; border-color: #FF9923; color: #fff; }
            .mz-topbar-links { display: flex; align-items: center; gap: 4px; }
            .mz-topbar-links a {
                color: rgba(255,255,255,.75); font-size: 11.5px; text-decoration: none;
                padding: 2px 8px; border-radius: 4px; transition: color .2s;
            }
            .mz-topbar-links a:hover { color: #FF9923; }
            .mz-topbar-links .sep { color: rgba(255,255,255,.2); }
            .mz-back-link { color: #FF9923 !important; font-weight: 500; }

            /* Main header row */
            .mz-mainheader {
                background: #fff;
                box-shadow: 0 2px 16px rgba(15,23,42,.08);
                padding: 0;
            }
            .mz-mainheader-inner {
                padding: 0 24px;
                display: flex; align-items: center; gap: 20px; height: 68px;
            }

            /* Logo */
            .mz-logo img { max-height: 48px; display: block; }
            .mz-logo { flex-shrink: 0; text-decoration: none; }

            /* Search */
            .mz-searchbar {
                flex: 1; display: flex; align-items: center;
                background: #f1f5f9; border: 2px solid transparent;
                border-radius: 50px; overflow: hidden; transition: border-color .2s, background .2s;
            }
            .mz-searchbar:focus-within {
                background: #fff; border-color: #332a5e;
                box-shadow: 0 0 0 3px rgba(51,42,94,.08);
            }
            .mz-searchbar input {
                flex: 1; border: none; background: transparent; outline: none;
                padding: 10px 16px; font-size: 14px; color: #1e293b;
                font-family: 'Inter', sans-serif;
            }
            .mz-searchbar input::placeholder { color: #94a3b8; }
            .mz-searchbar button {
                background: #332a5e; border: none; color: #fff;
                padding: 8px 20px; cursor: pointer; font-size: 15px;
                border-radius: 0 50px 50px 0; transition: background .2s;
                display: flex; align-items: center; height: 44px;
            }
            .mz-searchbar button:hover { background: #FF9923; }

            /* Header icon buttons */
            .mz-hdr-icons { display: flex; align-items: center; gap: 4px; flex-shrink: 0; }
            .mz-hbtn {
                display: flex; flex-direction: column; align-items: center; gap: 1px;
                color: #1e293b; text-decoration: none; background: none; border: none;
                padding: 6px 10px; border-radius: 8px; cursor: pointer;
                transition: color .2s, background .2s; position: relative; min-width: 48px;
            }
            .mz-hbtn i, .mz-hbtn svg { font-size: 20px; display: block; }
            .mz-hbtn span { font-size: 10px; font-weight: 600; white-space: nowrap; color: #64748b; }
            .mz-hbtn:hover { color: #332a5e; background: #f0edf8; }
            .mz-hbtn:hover span { color: #332a5e; }
            .mz-badge {
                position: absolute; top: 2px; right: 4px;
                background: #FF9923; color: #fff; font-size: 9px; font-weight: 700;
                border-radius: 50%; width: 16px; height: 16px;
                display: flex; align-items: center; justify-content: center;
                border: 2px solid #fff;
            }
            .mz-hbtn-active { color: #332a5e; }

            /* Mobile hamburger */
            .mz-hamburger {
                display: none; flex-direction: column; justify-content: center; gap: 5px;
                background: none; border: none; cursor: pointer; padding: 8px; border-radius: 6px;
                transition: background .2s;
            }
            .mz-hamburger span { display: block; width: 22px; height: 2px; background: #1e293b; border-radius: 2px; transition: all .3s; }
            .mz-hamburger:hover { background: #f0edf8; }

            /* Category nav — remains as-is, theme color updated */
            .mz-catnav {
                background: #332a5e; border-bottom: 3px solid #FF9923;
            }
            .mz-catnav-inner {
                padding: 0 24px;
                display: flex; align-items: center;
            }
            .mz-catlink {
                display: flex; align-items: center; gap: 5px;
                color: rgba(255,255,255,.9); text-decoration: none;
                font-size: 13px; font-weight: 500; padding: 11px 14px;
                white-space: nowrap; transition: color .2s, background .2s;
                border-bottom: 3px solid transparent; margin-bottom: -3px;
            }
            .mz-catlink:hover, .mz-catlink.active {
                color: #FF9923; background: rgba(255,255,255,.07);
                border-bottom-color: #FF9923;
            }
            .mz-catlink i { font-size: 11px; opacity: .7; }
            .mz-catlink-all {
                background: rgba(255,255,255,.12); border-radius: 4px 4px 0 0;
                font-weight: 600; padding: 11px 16px;
            }
            .mz-catlink-all:hover { background: rgba(255,255,255,.2); }
            .mz-catnav-right { margin-left: auto; }

            /* Dropdown in cat nav */
            .mz-catnav .mz-dropdown { }
            .mz-catnav .mz-dropdown .mz-dropdown-menu { top: calc(100% + 3px); }

            /* Mobile search + nav */
            .mz-mobile-search {
                display: none; background: #fff; padding: 10px 16px;
                border-top: 1px solid #e9ecef;
            }
            .mz-mobile-nav-panel {
                display: none; position: fixed; inset: 0; z-index: 2000;
                background: rgba(15,23,42,.5); backdrop-filter: blur(2px);
            }
            .mz-mobile-nav-panel.show { display: block; }
            .mz-mobile-nav-drawer {
                position: fixed; top: 0; left: 0; bottom: 0; width: 300px;
                background: #fff; box-shadow: 4px 0 24px rgba(15,23,42,.15);
                overflow-y: auto; display: flex; flex-direction: column;
                transform: translateX(-100%); transition: transform .3s ease;
            }
            .mz-mobile-nav-panel.show .mz-mobile-nav-drawer { transform: translateX(0); }
            .mz-mnav-head {
                display: flex; align-items: center; justify-content: space-between;
                padding: 16px 20px; background: #332a5e; color: #fff;
            }
            .mz-mnav-head .brand { font-weight: 700; font-size: 15px; letter-spacing: .3px; }
            .mz-mnav-close {
                background: rgba(255,255,255,.15); border: none; color: #fff;
                width: 32px; height: 32px; border-radius: 50%; cursor: pointer;
                display: flex; align-items: center; justify-content: center; font-size: 14px;
            }
            .mz-mnav-body { flex: 1; padding: 8px 0; }
            .mz-mnav-item {
                display: flex; align-items: center; gap: 12px;
                padding: 13px 20px; color: #1e293b; text-decoration: none;
                font-size: 14px; font-weight: 500; border-bottom: 1px solid #f1f5f9;
                transition: background .15s, color .15s;
            }
            .mz-mnav-item i { width: 18px; color: #64748b; font-size: 14px; }
            .mz-mnav-item:hover { background: #f8fafc; color: #332a5e; }
            .mz-mnav-item:hover i { color: #332a5e; }
            .mz-mnav-item.accent { color: #FF9923; }
            .mz-mnav-item.danger { color: #dc2626; }
            .mz-mnav-section { padding: 8px 20px 4px; font-size: 10px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; }
            .mz-mnav-footer { padding: 16px 20px; border-top: 1px solid #f1f5f9; }

            /* Responsive */
            @media (max-width: 991px) {
                .mz-topbar { display: none; }
                .mz-searchbar { display: none; }
                .mz-catnav { display: none; }
                .mz-hamburger { display: flex; }
                .mz-hbtn span { display: none; }
                .mz-mainheader-inner { gap: 12px; }
            }
            @media (max-width: 575px) {
                .mz-hbtn { padding: 6px 7px; min-width: 40px; }
                .mz-mainheader-inner { padding: 0 14px; }
            }

            /* ================================================================
               CONTAINER — Override Konta/Tailwind default padding
               ================================================================ */
            body.store-page .container,
            body.store-page .container-fluid,
            body.store-page .container-sm,
            body.store-page .container-md,
            body.store-page .container-lg,
            body.store-page .container-xl,
            body.store-page .container-xxl {
                width: 100% !important;
                max-width: 1400px !important;
                margin-left: auto !important;
                margin-right: auto !important;
                padding-left: 24px !important;
                padding-right: 24px !important;
                box-sizing: border-box !important;
            }
            @media (max-width: 767px) {
                body.store-page .container {
                    padding-left: 14px !important;
                    padding-right: 14px !important;
                }
            }
            @media (max-width: 575px) {
                body.store-page .container { padding-left: 14px !important; padding-right: 14px !important; }
            }

            body.store-page .container.px-\[60px\] {
                padding-left: 24px !important;
                padding-right: 24px !important;
            }

            /* ---- Base — forms keep proper font ---- */
            .store-page input,
            .store-page textarea,
            .store-page select {
                font-family: 'Inter', 'Public Sans', sans-serif;
            }

            /* Breadcrumb banner used on store inner pages */
            .mz-breadcrumb-banner {
                background: #332a5e; padding: 22px 0 18px;
            }
            .mz-breadcrumb-banner .mz-bb-inner {
                padding: 0 24px; box-sizing: border-box;
            }
            .mz-breadcrumb-banner h1 {
                color: #fff; font-size: 20px; font-weight: 700; margin: 0 0 4px;
                font-family: 'Inter', sans-serif;
            }
            .mz-breadcrumb-banner nav { font-size: 12.5px; }
            .mz-breadcrumb-banner nav a { color: rgba(255,255,255,.7); text-decoration: none; }
            .mz-breadcrumb-banner nav a:hover { color: #FF9923; }
            .mz-breadcrumb-banner nav .sep { color: rgba(255,255,255,.3); margin: 0 7px; }
            .mz-breadcrumb-banner nav .current { color: #FF9923; }

            /* Store footer uses Konta CSS classes with store theme color */
            body.store-page .store-footer-wrapper { background: #2a2250; }
            body.store-page .store-footer-wrapper a,
            body.store-page .store-footer-wrapper a:hover { text-decoration: none; }

        </style>
    @else
        <style>
            body { font-family: var(--body-font, 'Public Sans', sans-serif); }
            body.main-site * { font-family: inherit; }
            body.main-site h1, body.main-site h2, body.main-site h3,
            body.main-site h4, body.main-site h5, body.main-site h6 {
                font-family: var(--title-font, 'Exo', sans-serif);
            }
            /* Font Awesome 6 Pro — prevent body * { font-family: inherit } from overriding */
            .fa, .fas, .far, .fal, .fat, .fa-solid, .fa-regular, .fa-light, .fa-thin { font-family: "Font Awesome 6 Pro" !important; }
            .fab, .fa-brands { font-family: "Font Awesome 6 Brands" !important; }
            .fad, .fa-duotone { font-family: "Font Awesome 6 Duotone" !important; }
            .th-header a, .th-header a:hover { text-decoration: none; }
            .footer-wrapper a, .footer-wrapper a:hover { text-decoration: none; }
            .th-btn { display: inline-block; }
            .preloader { display: block; }
            {!! core()->getConfigData('general.content.custom_scripts.custom_css') !!}
        </style>
    @endif

    @stack('styles')

    {!! view_render_event('bagisto.shop.layout.head.after') !!}
</head>

<body class="{{ $isStorePage ? 'store-page' : 'main-site' }}">
    {!! view_render_event('bagisto.shop.layout.body.before') !!}

    @if (!$isStorePage)
        {{-- Preloader (main site only) --}}
        <div class="preloader">
            <button class="th-btn style3 preloaderCls">Cancel Preloader</button>
            <div class="preloader-inner"><span class="loader"></span></div>
        </div>

        {{-- Side Widget Panel (main site only) --}}
        <div class="sidemenu-wrapper d-none d-lg-block">
            <div class="sidemenu-content sidemenu-area">
                <button class="closeButton sideMenuCls"><i class="far fa-times"></i></button>
                <div class="widget">
                    <div class="th-widget-about">
                        <div class="about-logo">
                            <a href="{{ route('shop.home.index') }}">
                                <img src="{{ asset('themes/shop/konta/img/logo-2.svg') }}" alt="Mazzy Automations">
                            </a>
                        </div>
                        <p class="about-text">We are regional leaders in smart home automation, Industrial automation and Intelligent automation. We offer smart lighting systems, security systems, air conditioning system as well as custom Industrial automation.</p>
                        <div class="th-social style2">
                            <h6 class="title">FOLLOW US ON:</h6>
                            <a href="https://www.facebook.com/profile.php?id=100076614051325" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://twitter.com/mazzy" target="_blank"><i class="fab fa-twitter"></i></a>
                            <a href="https://www.linkedin.com/mazzy" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                            <a href="https://m.youtube.com/channel/UCV56pyzWYD6xM_CEEyGfzew" target="_blank"><i class="fab fa-youtube"></i></a>
                            <a href="https://www.instagram.com/invites/contact/?i=6lyiuxkdo7y6&utm_content=nfh45nw" target="_blank"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <div class="widget widget_contact">
                    <h3 class="widget_title">Get in touch!</h3>
                    <div class="th-widget-contact">
                        <div class="info-box-wrap">
                            <div class="info-box_icon"><i class="fas fa-location-dot"></i></div>
                            <p class="info-box_text">Erf 598 Sandown, 165 West Street, Cnr Sandown Valley Crescent, Sandton</p>
                        </div>
                        <div class="info-box-wrap">
                            <div class="info-box_icon"><i class="fas fa-envelope"></i></div>
                            <a href="mailto:info@mazzyautomations.co.za" class="info-box_link">info@mazzyautomations.co.za</a>
                        </div>
                        <div class="info-box-wrap">
                            <div class="info-box_icon"><i class="fas fa-phone"></i></div>
                            <a href="tel:+27787972186" class="info-box_link">+27 787 972 186</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Popup Search (main site only) --}}
        <div class="popup-search-box d-none d-lg-block">
            <button class="searchClose"><i class="fal fa-times"></i></button>
            <form action="{{ route('shop.search.index') }}">
                <input type="text" name="query" placeholder="Search for products...">
                <button type="submit"><i class="fal fa-search"></i></button>
            </form>
        </div>

        {{-- Mobile Menu (main site only) --}}
        <div class="th-menu-wrapper">
            <div class="th-menu-area text-center">
                <button class="th-menu-toggle"><i class="fal fa-times"></i></button>
                <div class="mobile-logo">
                    <a href="{{ route('shop.home.index') }}">
                        <img src="{{ asset('themes/shop/konta/img/logo-2.svg') }}" alt="Mazzy Automations">
                    </a>
                </div>
                <div class="th-mobile-menu">
                    <ul>
                        <li><a href="{{ route('shop.home.index') }}">Home</a></li>
                        <li><a href="{{ route('shop.home.about_us') }}">Who We Are</a></li>
                        <li class="menu-item-has-children">
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
                                        <li><a href="{{ route('shop.home.solutions', 'alarm-and-access-control') }}">Alarm and Access Control</a></li>
                                    </ul>
                                </li>
                                <li><a href="{{ route('shop.home.solutions', 'smart-monitoring-and-control') }}">Smart Monitoring & Control</a></li>
                                <li><a href="{{ route('shop.home.solutions', 'smart-entertainment-systems') }}">Smart Entertainment Systems</a></li>
                            </ul>
                        </li>
                        <li><a href="{{ route('shop.home.our_work') }}">Our Work</a></li>
                        <li class="menu-item-has-children">
                            <a href="#">Media</a>
                            <ul class="sub-menu">
                                <li><a href="{{ route('shop.home.gallery') }}">Gallery</a></li>
                            </ul>
                        </li>
                        <li><a href="{{ route('shop.home.contact_us') }}">Contact</a></li>
                        <li><a href="{{ route('shop.home.store') }}">Visit Shop</a></li>
                    </ul>
                </div>
            </div>
        </div>
    @endif

    {{-- Vue App Root --}}
    <div style="margin-top: -30px;" id="app">
        <x-shop::flash-group />
        <x-shop::modal.confirm />

        {{-- Store pages: box all content (header + main + footer) to 1400 px --}}
        @if ($isStorePage)<div class="mz-page-wrapper">@endif

        @if ($hasHeader)
            @if ($isStorePage)
                <x-shop::layouts.header.store />
            @else
                <x-shop::layouts.header />
            @endif
        @endif

        {!! view_render_event('bagisto.shop.layout.content.before') !!}

        <main id="main">
            {{ $slot }}
        </main>

        {!! view_render_event('bagisto.shop.layout.content.after') !!}

            <x-shop::layouts.footer />

        @if (!$hasFooter)
            @if (!$isStorePage)
                <x-shop::layouts.footer />
            @else
                {{-- Store footer: uses Konta CSS classes with store-focused content --}}
                <footer class="footer-wrapper store-footer-wrapper">
                    <div class="widget-area" style="padding: 50px 0 20px;">
                        <div class="container">
                            <div class="row gy-4 justify-content-between">

                                {{-- Brand --}}
                                <div class="col-md-6 col-xl-3">
                                    <div class="widget footer-widget">
                                        <div class="th-widget-about">
                                            <div class="about-logo mb-3">
                                                <a href="{{ route('shop.home.store') }}">
                                                    <img src="{{ asset('themes/shop/konta/img/logo-white.svg') }}" alt="Mazzy Automations" style="max-height:48px;">
                                                </a>
                                            </div>
                                            <p class="about-text">South Africa's smart home automation store. Quality smart devices, home automation systems and intelligent security solutions.</p>
                                            <div class="th-social">
                                                <a href="https://www.facebook.com/profile.php?id=100076614051325" target="_blank"><i style="margin-top: 15px;" class="fab fa-facebook-f"></i></a>
                                                <a href="https://www.instagram.com/invites/contact/?i=6lyiuxkdo7y6&utm_content=nfh45nw" target="_blank"><i style="margin-top: 15px;" class="fab fa-instagram"></i></a>
                                                <a href="https://www.linkedin.com/company/78299265/" target="_blank"><i style="margin-top: 15px;" class="fab fa-linkedin-in"></i></a>
                                                <a href="https://m.youtube.com/channel/UCV56pyzWYD6xM_CEEyGfzew" target="_blank"><i style="margin-top: 15px;" class="fab fa-youtube"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Shop Categories --}}
                                <div class="col-md-6 col-xl-auto">
                                    <div class="widget widget_nav_menu footer-widget">
                                        <h3 class="widget_title">Shop Categories</h3>
                                        <div class="menu-all-pages-container">
                                            <ul class="menu">
                                                <li><a href="{{ route('shop.home.store') }}">All Products</a></li>
                                                <li><a href="{{ route('shop.search.index', ['query' => 'smart devices']) }}">Smart Devices</a></li>
                                                <li><a href="{{ route('shop.search.index', ['query' => 'smart lighting']) }}">Smart Lighting</a></li>
                                                <li><a href="{{ route('shop.search.index', ['query' => 'smart door lock']) }}">Smart Door Locks</a></li>
                                                <li><a href="{{ route('shop.search.index', ['query' => 'smart camera']) }}">Smart Cameras</a></li>
                                                <li><a href="{{ route('shop.search.index', ['query' => 'accessories']) }}">Accessories</a></li>
                                                <li><a href="{{ route('shop.compare.index') }}">Compare Products</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                {{-- Customer Service --}}
                                <div class="col-md-6 col-xl-auto">
                                    <div class="widget widget_nav_menu footer-widget">
                                        <h3 class="widget_title">Customer Service</h3>
                                        <div class="menu-all-pages-container">
                                            <ul class="menu">
                                                <li><a href="{{ route('shop.customers.account.orders.index') }}">Track My Order</a></li>
                                                <li><a href="{{ route('shop.customers.account.profile.index') }}">My Account</a></li>
                                                <li><a href="{{ route('shop.customers.account.wishlist.index') }}">My Wishlist</a></li>
                                                <li><a href="{{ url('page/shipping-policy') }}">Shipping Policy</a></li>
                                                <li><a href="{{ url('page/terms-and-conditions') }}">Terms &amp; Conditions</a></li>
                                                <li><a href="{{ url('page/privacy-policy') }}">Privacy Policy</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                {{-- Contact --}}
                                <div class="col-md-6 col-xxl-3 col-xl-3">
                                    <div class="widget footer-widget">
                                        <h3 class="widget_title">Get In Touch</h3>
                                        <div class="th-widget-contact">
                                            <div class="info-box-wrap">
                                                <div class="info-box_icon"><i class="fas fa-phone"></i></div>
                                                <a href="tel:+27787972186" class="info-box_link">+27 787 972 186</a>
                                            </div>
                                            <div class="info-box-wrap">
                                                <div class="info-box_icon"><i class="fas fa-envelope"></i></div>
                                                <a href="mailto:info@mazzyautomations.co.za" class="info-box_link">info@mazzyautomations.co.za</a>
                                            </div>
                                            <div class="info-box-wrap">
                                                <div class="info-box_icon"><i class="fas fa-location-dot"></i></div>
                                                <p class="info-box_text">Erf 598 Sandown, 165 West Street, Sandton</p>
                                            </div>
                                            <div class="info-box-wrap mt-2">
                                                <div class="info-box_icon"><i class="fas fa-globe"></i></div>
                                                <a href="{{ route('shop.home.index') }}" class="info-box_link" style="color:#FF9923 !important;">&#8592; Back to Main Site</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    @if (core()->getConfigData('customer.settings.newsletter.subscription'))
                        <div class="newsletter-wrap py-4" style="background:rgba(255,255,255,.06);border-top:1px solid rgba(255,255,255,.1);">
                            <div class="container">
                                <div class="row align-items-center">
                                    <div class="col-lg-6">
                                        <h4 class="text-white mb-0">Subscribe to our newsletter!</h4>
                                    </div>
                                    <div class="col-lg-6 mt-3 mt-lg-0">
                                        <x-shop::form :action="route('shop.subscription.store')">
                                            <div class="newsletter-form form-group d-flex gap-2">
                                                <x-shop::form.control-group.control
                                                    type="email"
                                                    class="form-control"
                                                    name="email"
                                                    rules="required|email"
                                                    label="Email"
                                                    placeholder="Enter your email address"
                                                />
                                                <button type="submit" class="th-btn style3">
                                                    <i class="fas fa-paper-plane"></i>
                                                </button>
                                            </div>
                                        </x-shop::form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="copyright-wrap" style="border-top:1px solid rgba(255,255,255,.1);">
                        <div class="container">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-md-7">
                                    <p class="copyright-text">
                                        Copyright &copy; {{ date('Y') }}
                                        <a href="{{ route('shop.home.store') }}">Mazzy Automations</a>.
                                        All Rights Reserved.
                                    </p>
                                </div>
                                <div class="col-md-5 text-end d-none d-md-block">
                                    <div class="footer-links">
                                        <ul>
                                            <li><a href="{{ url('page/privacy-policy') }}">Privacy Policy</a></li>
                                            <li><a href="{{ url('page/terms-and-conditions') }}">Terms &amp; Conditions</a></li>
                                            <li><a href="{{ route('shop.home.contact_us') }}">Contact</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            @endif
        @endif

        @if ($isStorePage)</div>{{-- /.mz-page-wrapper --}}@endif
    </div>

    {{-- Scroll To Top (main site only) --}}
    @if (!$isStorePage)
    <div class="scroll-top">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;"></path>
        </svg>
    </div>
    @endif

    {!! view_render_event('bagisto.shop.layout.body.after') !!}

    @stack('scripts')

    {!! view_render_event('bagisto.shop.layout.vue-app-mount.before') !!}

    <script>
        window.addEventListener("load", function () {
            if (window.app) app.mount("#app");

            @if ($isStorePage)
            /* ---- Store: dropdown + mobile drawer init (runs after Vue mounts) ---- */
            (function () {
                function closeAllDropdowns() {
                    document.querySelectorAll('.mz-dropdown-menu.show').forEach(function (m) {
                        m.classList.remove('show');
                    });
                    document.querySelectorAll('.mz-dropdown [aria-expanded="true"]').forEach(function (t) {
                        t.setAttribute('aria-expanded', 'false');
                    });
                }

                document.querySelectorAll('.mz-dropdown').forEach(function (wrap) {
                    var trigger = wrap.querySelector('[id$="-btn"],[id^="cat-"],[id^="mz-acct"]');
                    var menu    = wrap.querySelector('.mz-dropdown-menu');
                    if (!trigger || !menu) return;

                    trigger.addEventListener('click', function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                        var isOpen = menu.classList.contains('show');
                        closeAllDropdowns();
                        if (!isOpen) {
                            menu.classList.add('show');
                            trigger.setAttribute('aria-expanded', 'true');
                        }
                    });
                });

                document.addEventListener('click', function (e) {
                    if (!e.target.closest('.mz-dropdown')) closeAllDropdowns();
                });

                var panel   = document.getElementById('mz-mobile-panel');
                var openBtn = document.getElementById('mz-open-nav');
                var closeBtn = document.getElementById('mz-close-nav');

                function openDrawer()  { if (panel) { panel.classList.add('show'); document.body.style.overflow = 'hidden'; } }
                function closeDrawer() { if (panel) { panel.classList.remove('show'); document.body.style.overflow = ''; } }

                if (openBtn)  openBtn.addEventListener('click',  openDrawer);
                if (closeBtn) closeBtn.addEventListener('click', closeDrawer);
                if (panel)    panel.addEventListener('click', function (e) { if (e.target === panel) closeDrawer(); });
                document.addEventListener('keydown', function (e) { if (e.key === 'Escape') { closeDrawer(); closeAllDropdowns(); } });
            })();
            @endif

            @if (!$isStorePage)
            /*
             * Load Konta scripts AFTER Vue has mounted so main.js IIFE runs
             * on the final Vue-rendered DOM.
             */
            function loadScript(src, cb) {
                var s = document.createElement('script');
                s.src = src;
                s.onload = cb || function(){};
                document.head.appendChild(s);
            }

            var pre = document.querySelector('.preloader');
            if (pre) { pre.style.opacity = '0'; pre.style.display = 'none'; }

            var base = '{{ asset("themes/shop/konta/js") }}';
            loadScript(base + '/vendor/jquery-3.6.0.min.js', function () {
                loadScript(base + '/app.min.js', function () {
                    loadScript(base + '/main.js', function () {
                        if (typeof jQuery !== 'undefined') {
                            jQuery('.slick-slider, .th-carousel').each(function() {
                                if (jQuery(this).hasClass('slick-initialized')) {
                                    jQuery(this).slick('refresh');
                                }
                            });
                            jQuery('[data-bg-src]').each(function() {
                                var src = jQuery(this).attr('data-bg-src');
                                jQuery(this).css('background-image', 'url(' + src + ')')
                                           .removeAttr('data-bg-src')
                                           .addClass('background-image');
                            });
                            if (jQuery.fn.counterUp) {
                                jQuery('.counter-number').counterUp({ delay: 10, time: 1000 });
                            }
                        }
                    });
                });
            });
            @endif
        });
    </script>

    {!! view_render_event('bagisto.shop.layout.vue-app-mount.after') !!}

    @if (!$isStorePage)
    <script type="text/javascript">
        {!! core()->getConfigData('general.content.custom_scripts.custom_javascript') !!}
    </script>
    @endif
</body>
</html>
