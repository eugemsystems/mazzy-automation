{!! view_render_event('bagisto.shop.layout.footer.before') !!}

<footer class="footer-wrapper footer-layout-default" data-bg-src="{{ asset('themes/shop/konta/img/bg/footer-bg.png') }}">
    <div class="widget-area space-top">
        <div class="container">
            <div class="row justify-content-between">

                {{-- About Column --}}
                <div class="col-md-6 col-xxl-3 col-xl-3">
                    <div class="widget footer-widget">
                        <div class="th-widget-about">
                            <div class="about-logo">
                                <a href="{{ route('shop.home.index') }}">
                                    <img src="{{ asset('themes/shop/konta/img/logo-white.svg') }}" alt="Mazzy Automations">
                                </a>
                            </div>
                            <p class="about-text">We are regional leaders in smart home automation, Industrial automation and Intelligent automation. We offer services like smart lighting systems, security systems, air conditioning system as well as Custom Industrial automation.</p>
                            <div class="th-social">
                                <a href="https://www.facebook.com/profile.php?id=100076614051325" target="_blank"><i style="margin-top: 15px;" class="fab fa-facebook-f"></i></a>
                                <a href="https://twitter.com/mazzy" target="_blank"><i style="margin-top: 15px;" class="fab fa-twitter"></i></a>
                                <a href="https://www.instagram.com/invites/contact/?i=6lyiuxkdo7y6&utm_content=nfh45nw" target="_blank"><i style="margin-top: 15px;" class="fab fa-instagram"></i></a>
                                <a href="https://www.linkedin.com/mazzy" target="_blank"><i style="margin-top: 15px;" class="fab fa-linkedin-in"></i></a>
                                <a href="https://m.youtube.com/channel/UCV56pyzWYD6xM_CEEyGfzew" target="_blank"><i style="margin-top: 15px;" class="fab fa-youtube"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- About Us Links --}}
                <div class="col-md-6 col-xl-auto">
                    <div class="widget widget_nav_menu footer-widget">
                        <h3 class="widget_title">About Us</h3>
                        <div class="menu-all-pages-container">
                            <ul class="menu">
                                <li><a href="{{ route('shop.home.about_us') }}">About Us</a></li>
                                <li><a href="{{ route('shop.home.planning_and_design') }}">Design Plan Packages</a></li>
                                <li><a href="{{ url('page/privacy-policy') }}">Privacy Policy</a></li>
                                <li><a href="{{ url('page/shipping-policy') }}">Shipping Policy</a></li>
                                <li><a href="{{ url('page/terms-and-conditions') }}">Terms and Conditions</a></li>
                                <li><a href="{{ route('shop.home.contact_us') }}">Contact Us</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Core Services --}}
                <div class="col-md-6 col-xl-auto">
                    <div class="widget widget_nav_menu footer-widget">
                        <h3 class="widget_title">Our Core Services</h3>
                        <div class="menu-all-pages-container">
                            <ul class="menu">
                                <li><a href="{{ route('shop.home.solutions', 'smart-monitoring-and-control') }}">Smart Monitoring and Control Systems</a></li>
                                <li><a href="{{ route('shop.home.solutions', 'smart-lighting-systems') }}">Home Automation</a></li>
                                <li><a href="{{ route('shop.home.solutions', 'smart-entertainment-systems') }}">Smart Entertainment Systems</a></li>
                                <li><a href="{{ route('shop.home.solutions', 'smart-controlled-light-strips') }}">Smart Controlled Light Strips</a></li>
                                <li><a href="{{ route('shop.home.solutions', 'smart-hotel-solutions') }}">Smart Hotel Solutions</a></li>
                                <li><a href="{{ route('shop.home.solutions', 'alarm-and-access-control') }}">Alarm and Access Control Systems</a></li>
                                <li><a href="{{ route('shop.home.solutions', 'smart-security-sensors') }}">Smart Security Sensors</a></li>
                                <li><a href="{{ route('shop.home.solutions', 'iot-systems') }}">IP Telephony &amp; Networking</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Gallery Widget (Konta original structure) --}}
                <div class="col-md-6 col-xxl-3 col-xl-3">
                    <div class="widget footer-widget">
                        <h3 class="widget_title">Our Gallery</h3>
                        <div class="widget-gallery">
                            <div class="gallery-thumb">
                                <img src="{{ asset('themes/shop/konta/img/normal/f1.webp') }}" alt="Gallery Image">
                                <a href="{{ asset('themes/shop/konta/img/normal/f1.webp') }}" class="gallery-btn popup-image"><i class="fab fa-instagram"></i></a>
                            </div>
                            <div class="gallery-thumb">
                                <img src="{{ asset('themes/shop/konta/img/normal/f2.webp') }}" alt="Gallery Image">
                                <a href="{{ asset('themes/shop/konta/img/normal/f2.webp') }}" class="gallery-btn popup-image"><i class="fab fa-instagram"></i></a>
                            </div>
                            <div class="gallery-thumb">
                                <img src="{{ asset('themes/shop/konta/img/normal/f3.webp') }}" alt="Gallery Image">
                                <a href="{{ asset('themes/shop/konta/img/normal/f3.webp') }}" class="gallery-btn popup-image"><i class="fab fa-instagram"></i></a>
                            </div>
                            <div class="gallery-thumb">
                                <img src="{{ asset('themes/shop/konta/img/normal/f4.jpeg') }}" alt="Gallery Image">
                                <a href="{{ asset('themes/shop/konta/img/normal/f4.jpeg') }}" class="gallery-btn popup-image"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Newsletter Subscription --}}
    @if (core()->getConfigData('customer.settings.newsletter.subscription'))
        <div class="newsletter-wrap bg-theme py-4">
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

    {{-- Copyright --}}
    <div class="copyright-wrap">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-md-6">
                    <p class="copyright-text">
                        @if (core()->getConfigData('general.content.footer.copyright_content'))
                            {!! core()->getConfigData('general.content.footer.copyright_content') !!}
                        @else
                            Copyright &copy; {{ date('Y') }} <a href="{{ route('shop.home.index') }}">Mazzy Automations</a>. All Rights Reserved.
                        @endif
                    </p>
                </div>
                <div class="col-md-6 text-end d-none d-md-block">
                    <div class="footer-links">
                        <ul>
                            <li><a href="{{ url('page/privacy-policy') }}">Privacy Policy</a></li>
                            <li><a href="{{ url('page/terms-and-conditions') }}">Terms & Conditions</a></li>
                            <li><a href="{{ url('page/shipping-policy') }}">Shipping Policy</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

{!! view_render_event('bagisto.shop.layout.footer.after') !!}
