<x-shop::layouts>
    <x-slot:title>Contact Us - Mazzy Automations</x-slot>

    {{-- Breadcrumb --}}
    <div class="breadcumb-wrapper" data-bg-src="{{ asset('themes/shop/konta/img/bg/breadcumb-bg.jpg') }}">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Contact</h1>
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('shop.home.index') }}">Home</a></li>
                    <li>Contact</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Contact Info Boxes --}}
    <div class="space-top">
        <div class="container">

            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <div class="title-area">
                        <span class="sub-title"><i class="fas fa-address-card"></i> Reach Us</span>
                        <h2 class="sec-title">Our Contact Information</h2>
                    </div>
                </div>
            </div>
            <div class="row gy-4 justify-content-center" ><div class="col-xl-4 col-lg-6" ><div class="contact-feature" ><div class="contact-feature-icon" ><i class="fal fa-location-dot"></i></div><div class="media-body" ><p class="contact-feature_label">Our Address</p><span class="contact-info_text">{{ config('company.address') }}</span></div></div></div><div class="col-xl-4 col-lg-6" ><div class="contact-feature" ><div class="contact-feature-icon" ><i class="fal fa-phone"></i></div><div class="media-body" ><p class="contact-feature_label">Contact Number</p><a href="tel:{{ config('company.phone.mobile') }}" class="contact-feature_link">Mobile: {{ config('company.phone.mobile') }}</a><a href="tel:{{ config('company.phone.telephone') }}" class="contact-feature_link">Telephone: {{ config('company.phone.telephone') }}</a><a href="mailto:{{ config('company.email') }}" class="contact-feature_link">Email: {{ config('company.email') }}</a></div></div></div><div class="col-xl-4 col-lg-6" ><div class="contact-feature" ><div class="contact-feature-icon" ><i class="fal fa-clock"></i></div><div class="media-body" ><p class="contact-feature_label">Hours of Operation</p><span class="contact-feature_link">Monday - Friday: {{ config('company.hours.weekdays') }}</span>
                            <span class="contact-feature_link">Saturday: {{ config('company.hours.saturday') }}</span>
                            <span class="contact-feature_link">Sunday: {{ config('company.hours.sunday') }}</span></div></div></div></div>
        </div>
    </div>

    {{-- Contact Form + Map --}}
    <div class="space-extra-bottom">
        <div class="container">
            <div class="row gy-5">
                {{-- Form --}}
                <div class="col-lg-7">
                    <div class="title-area mb-35">
                        <span class="sub-title"><i class="fas fa-paper-plane"></i> Get In Touch</span>
                        <h2 class="sec-title">Send Us A Message</h2>
                    </div>

                    <x-shop::form :action="route('shop.home.contact_us.send_mail')">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group style-border mb-20">
                                    <x-shop::form.control-group.control
                                        type="text"
                                        class="form-control"
                                        name="name"
                                        rules="required"
                                        label="Your Name"
                                        placeholder="Your Name"
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
                                        placeholder="Email Address"
                                        :value="old('email')"
                                    />
                                    <x-shop::form.control-group.error control-name="email" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group style-border mb-20">
                                    <x-shop::form.control-group.control
                                        type="text"
                                        class="form-control"
                                        name="contact"
                                        rules="phone"
                                        label="Phone Number"
                                        placeholder="Phone Number"
                                        :value="old('contact')"
                                    />
                                    <x-shop::form.control-group.error control-name="contact" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group style-border mb-20">
                                    <select class="form-control" name="subject">
                                        <option value="">Select Quote Type</option>
                                        <option value="Design and Planning Quote">Design and Planning Quote</option>
                                        <option value="Home Automation Quote">Home Automation Quote</option>
                                        <option value="Industrial Automation Quote">Industrial Automation Quote</option>
                                        <option value="Smart Security Quote">Smart Security Quote</option>
                                        <option value="General Inquiry">General Inquiry</option>
                                    </select>
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
                                        placeholder="Write your message..."
                                        rows="6"
                                    />
                                    <x-shop::form.control-group.error control-name="message" />
                                </div>
                            </div>

                            @if (core()->getConfigData('customer.captcha.credentials.status'))
                                <div class="col-12 mb-20">
                                    {!! \Webkul\Customer\Facades\Captcha::render() !!}
                                    <x-shop::form.control-group.error control-name="recaptcha_token" />
                                </div>
                            @endif

                            <div class="col-12">
                                <button type="submit" class="th-btn">
                                    Send Message <i class="fas fa-paper-plane ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </x-shop::form>
                </div>

                {{-- Map --}}
                <div class="col-lg-5">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7165.761380994825!2d28.048718476287178!3d-26.102813059854004!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1e957331af137053%3A0x863bf8154f435015!2s2%20Sandown%20Valley%20Cres%2C%20Sandown%2C%20Sandton%2C%202031!5e0!3m2!1sen!2sza!4v1784564820137!5m2!1sen!2sza"
                        width="100%"
                        height="100%"
                        style="min-height:450px; border:0; border-radius:8px;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                    ></iframe>
                    
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        {!! \Webkul\Customer\Facades\Captcha::renderJS() !!}
    @endpush
</x-shop::layouts>
