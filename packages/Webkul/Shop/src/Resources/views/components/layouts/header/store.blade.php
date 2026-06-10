{{-- Mazzy Automations — Store Header --}}
<header class="mz-header">

    {{-- ===== TOP BAR (desktop only) ===== --}}
    <div class="mz-topbar">
        <div class="mz-topbar-inner">
            <div class="mz-topbar-msg">
                <i class="fas fa-shield-alt"></i>
                <span>Secure &amp; trusted delivery &mdash; Free shipping on orders over R500</span>
            </div>
            <div class="mz-topbar-right">
                <div class="mz-social-links">
                    <a href="https://www.facebook.com/mazzyautomations" target="_blank" rel="noopener" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.instagram.com/mazzyautomations" target="_blank" rel="noopener" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.youtube.com/@MazzyAutomations" target="_blank" rel="noopener" title="YouTube"><i class="fab fa-youtube"></i></a>
                    <a href="https://www.linkedin.com/company/78299265/" target="_blank" rel="noopener" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <div class="mz-topbar-links">
                    <a href="{{ route('shop.customers.account.orders.index') }}"><i class="fas fa-truck" style="margin-right:3px;"></i> Track Order</a>
                    <span class="sep">|</span>
                    <a href="{{ route('shop.home.contact_us') }}">Contact</a>
                    <span class="sep">|</span>
                    <a href="{{ route('shop.home.index') }}" class="mz-back-link"><i class="fas fa-arrow-left" style="font-size:10px; margin-right:3px;"></i> Main Site</a>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== MAIN HEADER ROW ===== --}}
    <div class="mz-mainheader">
        <div class="mz-mainheader-inner">

            {{-- Logo --}}
            <a href="{{ route('shop.home.store') }}" class="mz-logo">
                <img
                    src="{{asset('themes/shop/konta/img/logo-shop.png') }}"
                    alt="Mazzy Automations"
                >
            </a>

            {{-- Search (desktop) --}}
            <form class="mz-searchbar" action="{{ route('shop.search.index') }}" role="search" style="margin: 0 8px;">
                <input
                    type="text"
                    name="query"
                    placeholder="Search for automation products..."
                    value="{{ request('query') }}"
                    autocomplete="off"
                >
                <button type="submit" aria-label="Search">
                    <i class="fas fa-search"></i>
                </button>
            </form>

            {{-- Right icon buttons --}}
            <div class="mz-hdr-icons">

                {{-- Wishlist --}}
                @auth('customer')
                    <a href="{{ route('shop.customers.account.wishlist.index') }}" class="mz-hbtn" title="Wishlist">
                        <i class="far fa-heart"></i>
                        <span>Wishlist</span>
                    </a>
                @endauth

                {{-- Account --}}
                <div class="mz-dropdown">
                    @auth('customer')
                        <button class="mz-hbtn" id="mz-acct-btn" type="button" aria-expanded="false">
                            <i class="far fa-user-circle"></i>
                            <span>Account</span>
                        </button>
                        <div class="mz-dropdown-menu end" id="mz-acct-menu" role="menu">
                            <a class="mz-dropdown-item" href="{{ route('shop.customers.account.profile.index') }}">
                                <i class="fas fa-user-cog" style="width:16px; color:#332a5e;"></i> My Profile
                            </a>
                            <a class="mz-dropdown-item" href="{{ route('shop.customers.account.orders.index') }}">
                                <i class="fas fa-box-open" style="width:16px; color:#332a5e;"></i> My Orders
                            </a>
                            <a class="mz-dropdown-item" href="{{ route('shop.customers.account.addresses.index') }}">
                                <i class="fas fa-map-marker-alt" style="width:16px; color:#332a5e;"></i> Addresses
                            </a>
                            <a class="mz-dropdown-item" href="{{ route('shop.customers.account.wishlist.index') }}">
                                <i class="fas fa-heart" style="width:16px; color:#332a5e;"></i> Wishlist
                            </a>
                            <div class="mz-dropdown-divider"></div>
                            <a class="mz-dropdown-item danger" href="#"
                               onclick="event.preventDefault(); document.getElementById('mz-logout-form').submit();">
                                <i class="fas fa-sign-out-alt" style="width:16px;"></i> Sign Out
                            </a>
                            <form id="mz-logout-form" action="{{ route('shop.customer.session.destroy') }}" method="POST" style="display:none;">
                                @csrf @method('DELETE')
                            </form>
                        </div>
                    @else
                        <a href="{{ route('shop.customer.session.index') }}" class="mz-hbtn" title="Sign In">
                            <i class="far fa-user-circle"></i>
                            <span>Sign In</span>
                        </a>
                    @endauth
                </div>

                {{-- Cart --}}
                @if (core()->getConfigData('sales.checkout.shopping_cart.cart_page'))
                    @include('shop::checkout.cart.mini-cart')
                @endif

                {{-- Mobile hamburger --}}
                <button class="mz-hamburger" id="mz-open-nav" aria-label="Open menu" aria-expanded="false">
                    <span></span><span></span><span></span>
                </button>

            </div>
        </div>
    </div>

    {{-- ===== CATEGORY NAV (desktop only) ===== --}}
    <nav class="mz-catnav" aria-label="Product categories">
        <div class="mz-catnav-inner">

            <a href="{{ route('shop.home.store') }}" class="mz-catlink mz-catlink-all">
                <i class="fas fa-th-large"></i> All Products
            </a>

            {{-- Smart Devices dropdown --}}
            <div class="mz-dropdown">
                <a href="javascript:void(0)" class="mz-catlink" id="cat-smart" role="button" aria-expanded="false" aria-haspopup="true">
                    Smart Devices <i class="fas fa-chevron-down"></i>
                </a>
                <div class="mz-dropdown-menu" id="cat-smart-menu">
                    <a class="mz-dropdown-item" href="{{ route('shop.search.index', ['query' => 'smart alarm']) }}"><i class="fas fa-bell" style="color:#332a5e; width:16px;"></i> Smart Alarm Systems</a>
                    <a class="mz-dropdown-item" href="{{ route('shop.search.index', ['query' => 'smart door lock']) }}"><i class="fas fa-lock" style="color:#332a5e; width:16px;"></i> Smart Door Locks</a>
                    <a class="mz-dropdown-item" href="{{ route('shop.search.index', ['query' => 'smart curtain']) }}"><i class="fas fa-blinds" style="color:#332a5e; width:16px;"></i> Smart Curtain Systems</a>
                    <a class="mz-dropdown-item" href="{{ route('shop.search.index', ['query' => 'garage opener']) }}"><i class="fas fa-warehouse" style="color:#332a5e; width:16px;"></i> Garage Openers</a>
                    <a class="mz-dropdown-item" href="{{ route('shop.search.index', ['query' => 'smart camera']) }}"><i class="fas fa-video" style="color:#332a5e; width:16px;"></i> Smart Cameras</a>
                    <a class="mz-dropdown-item" href="{{ route('shop.search.index', ['query' => 'smart switch']) }}"><i class="fas fa-toggle-on" style="color:#332a5e; width:16px;"></i> Smart Switches</a>
                    <a class="mz-dropdown-item" href="{{ route('shop.search.index', ['query' => 'zigbee gateway']) }}"><i class="fas fa-network-wired" style="color:#332a5e; width:16px;"></i> Zigbee Gateways</a>
                    <a class="mz-dropdown-item" href="{{ route('shop.search.index', ['query' => 'smart sensor']) }}"><i class="fas fa-satellite-dish" style="color:#332a5e; width:16px;"></i> Smart Sensors</a>
                </div>
            </div>

            {{-- Home Automation dropdown --}}
            <div class="mz-dropdown">
                <a href="javascript:void(0)" class="mz-catlink" id="cat-home" role="button" aria-expanded="false" aria-haspopup="true">
                    Home Automation <i class="fas fa-chevron-down"></i>
                </a>
                <div class="mz-dropdown-menu" id="cat-home-menu">
                    <a class="mz-dropdown-item" href="{{ route('shop.search.index', ['query' => 'smart lighting']) }}"><i class="fas fa-lightbulb" style="color:#332a5e; width:16px;"></i> Smart Lighting</a>
                    <a class="mz-dropdown-item" href="{{ route('shop.search.index', ['query' => 'smart speaker']) }}"><i class="fas fa-volume-up" style="color:#332a5e; width:16px;"></i> Smart Speakers</a>
                    <a class="mz-dropdown-item" href="{{ route('shop.search.index', ['query' => 'smart audio']) }}"><i class="fas fa-music" style="color:#332a5e; width:16px;"></i> Home Audio Systems</a>
                    <a class="mz-dropdown-item" href="{{ route('shop.search.index', ['query' => 'smart gateway']) }}"><i class="fas fa-wifi" style="color:#332a5e; width:16px;"></i> Smart Gateways</a>
                </div>
            </div>

            <a href="{{ route('shop.search.index', ['query' => 'accessories']) }}" class="mz-catlink">Accessories</a>
            <a href="{{ route('shop.compare.index') }}" class="mz-catlink">Compare</a>

            {{-- Account (right side of catnav) --}}
            <div class="mz-dropdown mz-catnav-right">
                <a href="javascript:void(0)" class="mz-catlink" id="cat-acct" role="button" aria-expanded="false" aria-haspopup="true">
                    <i class="far fa-user-circle"></i>
                    @auth('customer') {{ auth('customer')->user()->first_name }} @else Sign In @endauth
                    <i class="fas fa-chevron-down"></i>
                </a>
                <div class="mz-dropdown-menu end" id="cat-acct-menu">
                    @guest('customer')
                        <a class="mz-dropdown-item" href="{{ route('shop.customer.session.index') }}"><i class="fas fa-sign-in-alt" style="color:#332a5e; width:16px;"></i> Sign In</a>
                        <a class="mz-dropdown-item" href="{{ route('shop.customers.register.index') }}"><i class="fas fa-user-plus" style="color:#332a5e; width:16px;"></i> Create Account</a>
                    @endguest
                    @auth('customer')
                        <a class="mz-dropdown-item" href="{{ route('shop.customers.account.profile.index') }}"><i class="fas fa-user-cog" style="color:#332a5e; width:16px;"></i> My Profile</a>
                        <a class="mz-dropdown-item" href="{{ route('shop.customers.account.orders.index') }}"><i class="fas fa-box-open" style="color:#332a5e; width:16px;"></i> My Orders</a>
                        <a class="mz-dropdown-item" href="{{ route('shop.customers.account.wishlist.index') }}"><i class="fas fa-heart" style="color:#332a5e; width:16px;"></i> Wishlist</a>
                        <div class="mz-dropdown-divider"></div>
                        <a class="mz-dropdown-item danger" href="#"
                           onclick="event.preventDefault(); document.getElementById('mz-logout-form').submit();">
                            <i class="fas fa-sign-out-alt" style="width:16px;"></i> Sign Out
                        </a>
                    @endauth
                </div>
            </div>

        </div>
    </nav>

    {{-- ===== MOBILE NAV DRAWER ===== --}}
    <div class="mz-mobile-nav-panel" id="mz-mobile-panel" role="dialog" aria-modal="true" aria-label="Navigation menu">
        <div class="mz-mobile-nav-drawer">
            <div class="mz-mnav-head">
                <span class="brand"><i class="fas fa-bolt" style="color:#FF9923; margin-right:6px;"></i> Mazzy Store</span>
                <button class="mz-mnav-close" id="mz-close-nav" aria-label="Close menu">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            {{-- Mobile search --}}
            <div style="padding: 12px 16px; background: #f8fafc; border-bottom: 1px solid #e9ecef;">
                <form action="{{ route('shop.search.index') }}" role="search">
                    <div style="display:flex; border:2px solid #332a5e; border-radius:50px; overflow:hidden;">
                        <input type="text" name="query" placeholder="Search products..."
                               value="{{ request('query') }}" autocomplete="off"
                               style="flex:1; border:none; outline:none; padding:9px 14px; font-size:13px; background:transparent; color:#1e293b;">
                        <button type="submit" style="background:#332a5e; border:none; color:#fff; padding:8px 16px; cursor:pointer; border-radius:0 50px 50px 0;">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>

            <div class="mz-mnav-body">
                <div class="mz-mnav-section">Shop</div>
                <a href="{{ route('shop.home.store') }}" class="mz-mnav-item"><i class="fas fa-th-large"></i> All Products</a>
                <a href="{{ route('shop.search.index', ['query' => 'smart devices']) }}" class="mz-mnav-item"><i class="fas fa-microchip"></i> Smart Devices</a>
                <a href="{{ route('shop.search.index', ['query' => 'home automation']) }}" class="mz-mnav-item"><i class="fas fa-home"></i> Home Automation</a>
                <a href="{{ route('shop.search.index', ['query' => 'accessories']) }}" class="mz-mnav-item"><i class="fas fa-plug"></i> Accessories</a>
                <a href="{{ route('shop.compare.index') }}" class="mz-mnav-item"><i class="fas fa-exchange-alt"></i> Compare</a>

                @auth('customer')
                    <div class="mz-mnav-section" style="margin-top:6px;">Account</div>
                    <a href="{{ route('shop.customers.account.profile.index') }}" class="mz-mnav-item"><i class="fas fa-user-cog"></i> My Profile</a>
                    <a href="{{ route('shop.customers.account.orders.index') }}" class="mz-mnav-item"><i class="fas fa-box-open"></i> My Orders</a>
                    <a href="{{ route('shop.customers.account.wishlist.index') }}" class="mz-mnav-item"><i class="fas fa-heart"></i> Wishlist</a>
                    <a href="{{ route('shop.customers.account.addresses.index') }}" class="mz-mnav-item"><i class="fas fa-map-marker-alt"></i> Addresses</a>
                    <a href="#" class="mz-mnav-item danger"
                       onclick="event.preventDefault(); document.getElementById('mz-logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Sign Out
                    </a>
                @else
                    <div class="mz-mnav-section" style="margin-top:6px;">Account</div>
                    <a href="{{ route('shop.customer.session.index') }}" class="mz-mnav-item"><i class="fas fa-sign-in-alt"></i> Sign In</a>
                    <a href="{{ route('shop.customers.register.index') }}" class="mz-mnav-item"><i class="fas fa-user-plus"></i> Create Account</a>
                @endauth
            </div>

            <div class="mz-mnav-footer">
                <a href="{{ route('shop.home.index') }}" style="color:#FF9923; text-decoration:none; font-size:13px; font-weight:600; display:flex; align-items:center; gap:6px;">
                    <i class="fas fa-arrow-left"></i> Back to Main Site
                </a>
            </div>
        </div>
    </div>

</header>
