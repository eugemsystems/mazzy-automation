<x-shop::layouts>
    <x-slot:title>Gallery - Mazzy Automations</x-slot>

    {{-- Breadcrumb --}}
    <div class="breadcumb-wrapper" data-bg-src="{{ asset('themes/shop/konta/img/bg/breadcumb-bg.jpg') }}">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Gallery</h1>
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('shop.home.index') }}">Home</a></li>
                    <li>Gallery</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Gallery Section --}}
    <div class="space-top space-extra-bottom">
        <div class="container">
            <div class="row justify-content-center mb-60">
                <div class="col-lg-8 text-center">
                    <div class="title-area">
                        <span class="sub-title"><i class="fas fa-images"></i> Our Products</span>
                        <h2 class="sec-title">Smart Automation Products & Solutions</h2>
                        <p class="sec-text">Explore our range of smart home and industrial automation products. From smart switches and scene panels to zigbee gateways and security systems.</p>
                    </div>
                </div>
            </div>

            <div class="row gy-4">
                <div class="sidebar-gallery" >
                    <div class="gallery-thumb" >
                        <img decoding="async" src="{{asset('themes/shop/konta/img/gallery/2022-Professional-manufacturer-home-smart-switches-with-1.webp')}}" alt="2022 Professional manufacturer home smart switches with 1">        </div>
                    <div class="gallery-thumb" >
                        <img decoding="async" src="{{asset('themes/shop/konta/img/gallery/2022-Professional-manufacturer-home-smart-switches-with-2.webp')}}" alt="2022 Professional manufacturer home smart switches with 2">        </div>
                    <div class="gallery-thumb" >
                        <img decoding="async" src="{{asset('themes/shop/konta/img/gallery/Smart-zigbee-switch-Mult-functional-smart-switch.webp')}}" alt="Smart zigbee switch Mult functional smart switch">        </div>
                    <div class="gallery-thumb" >
                        <img decoding="async" src="{{asset('themes/shop/konta/img/gallery/Smart-zigbee-switch-Mult-functional-smart-switch-3.webp')}}" alt="Smart zigbee switch Mult functional smart switch 3">        </div>
                    <div class="gallery-thumb" >
                        <img decoding="async" src="{{asset('themes/shop/konta/img/gallery/Smart-zigbee-switch-Mult-functional-smart-switch-2.webp')}}" alt="Smart zigbee switch Mult functional smart switch 2">        </div>
                    <div class="gallery-thumb" >
                        <img decoding="async" src="{{asset('themes/shop/konta/img/gallery/Smart-zigbee-switch-Mult-functional-smart-switch-5.webp')}}" alt="Smart zigbee switch Mult functional smart switch 5">        </div>
                    <div class="gallery-thumb" >
                        <img decoding="async" src="{{asset('themes/shop/konta/img/gallery/2022-Professional-manufacturer-home-smart-switches-with-3.webp')}}" alt="2022 Professional manufacturer home smart switches with 3">        </div>
                    <div class="gallery-thumb" >
                        <img decoding="async" src="{{asset('themes/shop/konta/img/gallery/2022-new-tuya-zigbee-smart-switch-with-2.webp')}}" alt="2022 new tuya zigbee smart switch with 2">        </div>
                    <div class="gallery-thumb" >
                        <img decoding="async" src="{{asset('themes/shop/konta/img/gallery/2022-new-tuya-zigbee-smart-switch-with-1.webp')}}" alt="2022 new tuya zigbee smart switch with 1">        </div>
                    <div class="gallery-thumb" >
                        <img decoding="async" src="{{asset('themes/shop/konta/img/gallery/2022-new-arrival-smart-home-automation-tuya-4.webp')}}" alt="2022 new arrival smart home automation tuya 4">        </div>
                    <div class="gallery-thumb" >
                        <img decoding="async" src="{{asset('themes/shop/konta/img/gallery/2022-new-arrival-custom-scene-panel-with-5.webp')}}" alt="2022 new arrival custom scene panel with 5">        </div>
                    <div class="gallery-thumb" >
                        <img decoding="async" src="{{asset('themes/shop/konta/img/gallery/Factory-direct-smart-wall-switch-with-4.webp')}}" alt="Factory direct smart wall switch with 4">        </div>
                    <div class="gallery-thumb" >
                        <img decoding="async" src="{{asset('themes/shop/konta/img/gallery/Factory-direct-smart-wall-switch-with-4-1.webp')}}" alt="Factory direct smart wall switch with 4 1">        </div>
                    <div class="gallery-thumb" >
                        <img decoding="async" src="{{asset('themes/shop/konta/img/gallery/Factory-direct-smart-wall-switch-with-4-3.webp')}}" alt="Factory direct smart wall switch with 4 3">        </div>
                </div>
            </div>

            <div class="text-center mt-60">
                <a href="{{ route('shop.home.store') }}" class="th-btn">Shop All Products <i class="fas fa-shopping-bag ms-2"></i></a>
            </div>
        </div>
    </div>
</x-shop::layouts>
