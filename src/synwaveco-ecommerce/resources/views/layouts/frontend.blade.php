<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light" data-pwa="true">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@yield('title', 'Home Page') - {{ config('app.name', 'SynWavEco') }}</title>

    {{-- Favicons --}}
    <link rel="preload" href="{{ asset('public/images/favicon.ico') }}" as="image" type="image/x-icon">
    <link rel="icon" type="image/x-icon" href="{{ asset('public/images/favicon.ico') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/images/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('public/images/favicon.ico') }}">
    <link rel="icon" type="image/jpg" href="{{ asset('public/images/synwaveco-logo') }}" sizes="32x32" />
    <link rel="apple-touch-icon" href="{{ asset('public/images/synwaveco-logo') }}" />

    {{-- Theme Switcher Script --}}
    <script src="{{ asset('public/assets/js/theme-switcher.js') }}"></script>

    {{-- Fonts & Icons --}}
    <link rel="preload" href="{{ asset('public/assets/fonts/inter-variable-latin.woff2') }}" as="font" type="font/woff2" crossorigin />
    <link rel="preload" href="{{ asset('public/assets/icons/cartzilla-icons.woff2') }}" as="font" type="font/woff2" crossorigin />
    <link rel="stylesheet" href="{{ asset('public/assets/icons/cartzilla-icons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/vendor/font-awesome/css/all.min.css') }}">

    {{-- Vendor Libraries --}}
    <link rel="stylesheet" href="{{ asset('public/assets/vendor/swiper/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/vendor/choices.js/choices.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/assets/vendor/flatpickr/flatpickr.min.css') }}">

    {{-- Cartzilla Theme CSS --}}
    <link rel="preload" href="{{ asset('public/assets/css/theme.min.css') }}" as="style" />
    <link rel="stylesheet" href="{{ asset('public/assets/css/theme.min.css') }}" id="theme-styles" />

    {{-- SYNWAVECO CUSTOM CSS - GreenTech Override --}}
    <link rel="stylesheet" href="{{ asset('public/css/frontend-custom.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/css/layout.css') }}" />
    {{-- Custom Styles --}}
    @yield('css')
</head>

<body>
    {{-- Search Box Modal --}}
    <div class="offcanvas offcanvas-top" id="searchBox" data-bs-backdrop="static" tabindex="-1">
        <div class="offcanvas-header d-block bg-body py-4">
            <div class="container">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h4 class="offcanvas-title text-primary"><i class="fas fa-search me-2"></i>Global Search</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>

                <form action="{{ route('frontend.search.products') }}" method="GET" id="globalSearchForm">
                    <div class="d-flex align-items-center">
                        <div class="input-group input-group-lg border shadow-sm rounded-pill overflow-hidden">
                            <span class="input-group-text bg-white border-0 ps-4">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="search" name="q" id="searchInputField"
                                class="form-control border-0 px-3"
                                placeholder="Type IoT product name or topic..."
                                required>
                        </div>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 ms-3 shadow">Find Now</button>
                    </div>

                    {{-- Chuyển đổi phạm vi tìm kiếm --}}
                    <div class="d-flex gap-4 mt-3 ps-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="search_scope" id="scopeProd" value="products" checked onchange="toggleSearchRoute(this.value)">
                            <label class="form-check-label small fw-bold text-muted" for="scopeProd">PRODUCTS</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="search_scope" id="scopeArt" value="articles" onchange="toggleSearchRoute(this.value)">
                            <label class="form-check-label small fw-bold text-muted" for="scopeArt">ARTICLES</label>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="offcanvas-body bg-body-tertiary">
            <div class="container text-center py-4">
                <div class="opacity-50 mb-3">
                    <i class="fas fa-terminal fa-3x"></i>
                </div>
                <h6 class="mb-1 text-dark">SynWavEco Search Engine</h6>
                <p class="fs-sm mb-0 text-muted">Enter product name, topic, or technology keywords.</p>
            </div>
        </div>


        <!--div class="offcanvas-body px-0">
            <div class="container text-center py-5">
                <i class="fas fa-microchip fa-3x text-body-tertiary opacity-60 mb-4"></i>
                <h6 class="mb-2">Ready to explore SynWavEco?</h6>
                <p class="fs-sm mb-0 text-muted">Type keywords above and press Enter to find what you need.</p>
            </div>
        </div-->

        <div class="offcanvas-header nav border-top px-0 py-3 mt-3 d-md-none">
            <ul class="navbar-nav w-100">
                @guest
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center justify-content-center" href="{{ route('user.login') }}">
                        <i class="fas fa-sign-in-alt fs-lg opacity-60 me-2"></i> Log In
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center justify-content-center" href="{{ route('user.register') }}">
                        <i class="fas fa-user-plus fs-sm opacity-60 me-2"></i> Register
                    </a>
                </li>
                @else
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center justify-content-center" href="#" data-bs-toggle="dropdown">
                        <i class="fas fa-user fs-lg opacity-60 me-2"></i> {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-center border-0 shadow-none">
                        <li><a class="dropdown-item" href="{{ route('user.profile') }}"><i class="fas fa-user me-2"></i> Profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('user.logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i> Log Out
                            </a></li>
                        <form id="logout-form-mobile" action="{{ route('user.logout') }}" method="POST" class="d-none">@csrf</form>
                    </ul>
                </li>
                @endguest
            </ul>
        </div>
        <div class="offcanvas-body px-0">
            <div class="container text-center">
                <i class="fas fa-search fa-3x text-body-tertiary opacity-60 mb-4"></i>
                <h6 class="mb-2">Search results will appear here</h6>
                <p class="fs-sm mb-0">Start typing in the search box to see immediate results.</p>
            </div>
        </div>
    </div>

    {{-- Shopping Cart Offcanvas --}}
    <div class="offcanvas offcanvas-end pb-sm-2 px-sm-2" id="shoppingCart" tabindex="-1" style="width:500px">
        <div class="offcanvas-header flex-column align-items-start py-3 pt-lg-4">
            <div class="d-flex align-items-center justify-content-between w-100">
                <h4 class="offcanvas-title" id="shoppingCartLabel">My Shopping Cart ({{ Cart::count() ?? 0 }})</h4>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>
        </div>

        @if(Cart::count() > 0)
        <div class="offcanvas-body d-flex flex-column gap-4 pt-2">
            @foreach(Cart::content() as $value)
            <div class="d-flex align-items-center">
                <a class="flex-sm-shrink-0" href="#" style="width:142px">
                    <div class="ratio bg-body-tertiary rounded overflow-hidden" style="--cz-aspect-ratio:calc(110 / 142 * 100%)">
                        <img src="{{ asset('storage/app/private/' . $value->options->image ) }}" alt="Product" />
                    </div>
                </a>
                <div class="w-100 min-w-0 ps-3">
                    <h5 class="d-flex animate-underline mb-2">
                        <a class="d-block fs-sm fw-medium text-truncate animate-target" href="#">{{ $value->name }}</a>
                    </h5>
                    <div class="d-flex align-items-center justify-content-between gap-1">
                        <div class="h6 mt-1 mb-0">{{ number_format($value->price, 0, ',', '.') }}<small>$</small></div>
                        <a href="{{ route('frontend.shoppingcard.delete', ['row_id' => $value->rowId]) }}" class="btn btn-icon btn-sm flex-shrink-0 fs-sm" data-bs-toggle="tooltip" data-bs-title="Remove from cart">
                            <i class="fas fa-trash fs-base"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="offcanvas-header flex-column align-items-start">
            <div class="d-flex align-items-center justify-content-between w-100 mb-3 mb-md-4">
                <span class="text-light-emphasis">Total Price:</span>
                <span class="h6 mb-0">{{ Cart::priceTotal() }}<small>$</small></span>
            </div>
            <a class="btn btn-lg btn-primary w-100 rounded-pill" href="{{ route('frontend.shoppingcard') }}">View My Shopping Cart</a>
        </div>
        @else
        <div class="offcanvas-body text-center">
            <i class="fas fa-shopping-cart fa-3x text-body-tertiary opacity-60 mb-4"></i>
            <h6 class="mb-2">Your cart is currently empty!</h6>
            <p class="fs-sm mb-4">Explore our many items and add products to your cart.</p>
            <button type="button" class="btn btn-primary" data-bs-dismiss="offcanvas">Continue Shopping</button>
        </div>
        @endif
    </div>

    {{-- Page Wrapper --}}
    <div id="pageWrapper">
        {{-- HEADER COMPONENT --}}
        @include('frontend.partials.header')

        {{-- MAIN CONTENT --}}
        <main class="content-wrapper">
            @yield('content')
        </main>

        {{-- FOOTER COMPONENT --}}
        @include('frontend.partials.footer')
    </div>

    {{-- Floating Action Buttons --}}
    <div class="floating-buttons position-fixed top-50 end-0 z-sticky me-3 me-xl-4 pb-4" style="bottom: auto; transform: translateY(-50%);">
        {{-- Search Button --}}
        <button type="button" class="btn btn-lg btn-primary rounded-pill shadow-lg mb-3 d-flex align-items-center justify-content-center"
            data-bs-toggle="offcanvas" data-bs-target="#searchBox" style="width: 56px; height: 56px; padding: 0;">
            <i class="fas fa-search fs-5"></i>
        </button>

        {{-- Shopping Cart Button --}}
        <button type="button" class="btn btn-lg btn-success rounded-pill shadow-lg mb-3 d-flex align-items-center justify-content-center position-relative"
            data-bs-toggle="offcanvas" data-bs-target="#shoppingCart" style="width: 56px; height: 56px; padding: 0;">
            <i class="fas fa-shopping-cart fs-5"></i>
            @if(Cart::count() > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ Cart::count() }}
            </span>
            @endif
        </button>

        {{-- Scroll to Top Button --}}
        <a class="btn btn-lg btn-primary rounded-pill shadow-lg d-flex align-items-center justify-content-center"
            href="#top" style="width: 56px; height: 56px; padding: 0;">
            <i class="fas fa-chevron-up fs-5"></i>
        </a>
    </div>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simplebar@6.2.5/dist/simplebar.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js@10.2.0/public/assets/scripts/choices.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.querySelector('.navbar-sticky');
            const pageWrapper = document.getElementById('pageWrapper');

            if (navbar) {
                navbar.style.position = 'sticky';
                navbar.style.top = '0';
                navbar.style.zIndex = '9999';
                navbar.style.width = '100%';
            }

            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            console.log('✅ Frontend Layout: Initialized successfully');
        });

        // Theme switcher functionality
        function initializeThemeSwitcher() {
            const themeButtons = document.querySelectorAll('[data-bs-theme-value]');

            themeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const theme = this.getAttribute('data-bs-theme-value');
                    document.documentElement.setAttribute('data-bs-theme', theme);
                    localStorage.setItem('theme', theme);
                    themeButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            // Load saved theme
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-bs-theme', savedTheme);
        }

        initializeThemeSwitcher();
    </script>

    {{-- Custom JavaScript --}}
    @yield('javascript')
</body>

</html>