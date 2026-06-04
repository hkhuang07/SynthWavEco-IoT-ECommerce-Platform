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
    <!--link rel="stylesheet" href="{{ asset('css/home-additional-styles.css') }}">
    <script src="{{ asset('js/home-liveshow.js') }}"></script-->

    {{-- Custom Styles --}}
    @yield('css')
</head>

<body>
    {{-- Search Box Modal --}}
    <div class="offcanvas offcanvas-top" id="searchBox" data-bs-backdrop="static" tabindex="-1">
        <div class="offcanvas-header d-block py-4">
            <div class="container">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h4 class="offcanvas-title text-primary fw-bold"><i class="fas fa-search me-2"></i>Global Search</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>

                <form action="{{ route('frontend.search.product_results') }}" method="GET" id="globalSearchForm">
                    <div class="d-flex align-items-center">
                        <div class="input-group input-group-lg shadow-sm rounded-pill overflow-hidden">
                            <span class="input-group-text bg-white border-0 ps-4">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="search" name="q" id="searchInputField"
                                class="form-control border-0 px-3"
                                placeholder="Type product name or article topic..."
                                required>
                        </div>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 ms-3 shadow">Search</button>
                    </div>

                    {{-- Chuyển đổi phạm vi tìm kiếm linh hoạt --}}
                    <div class="d-flex gap-4 mt-3 ps-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="scope" id="scopeProd" value="products" checked onchange="updateSearchAction(this.value)">
                            <label class="form-check-label small fw-bold text-muted" for="scopeProd">IOT PRODUCTS</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="scope" id="scopeArt" value="articles" onchange="updateSearchAction(this.value)">
                            <label class="form-check-label small fw-bold text-muted" for="scopeArt">ARTICLES & NEWS</label>
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
    </div>


    @include('layouts.partials.sidebar')
    @include('layouts.partials.cart-offcanvas')

    {{-- Page Wrapper --}}
    <div id="pageWrapper" class="d-flex flex-column min-vh-100">
        {{-- HEADER COMPONENT --}}
        @include('layouts.partials.navbar')

        {{-- MAIN CONTENT --}}
        <main class="main-content" id="mainContent">
            @yield('content')
        </main>
        {{-- FOOTER COMPONENT --}}
        @include('frontend.partials.footer')
    </div>

    {{-- Floating Action Buttons --}}
    <div class="floating-buttons position-fixed top-50 end-0 z-sticky me-3 me-xl-4 pb-4" style="bottom: auto; transform: translateY(-50%);">
        <!--div class="floating-buttons position-fixed top-50 end-0 z-sticky me-3 me-xl-4 pb-4" style="transform: translateY(-50%);"-->
        {{-- Search Button --}}
        <button type="button" class="btn btn-lg btn-primary rounded-pill shadow-lg mb-3 d-flex align-items-center justify-content-center"
            data-bs-toggle="offcanvas" data-bs-target="#searchBox" style="width: 56px; height: 56px; padding: 0;">
            <i class="fas fa-search fs-5"></i>
        </button>
        <button type="button" id="btnOpenSearch"
            class="btn btn-lg btn-primary rounded-pill shadow-lg mb-3 d-none align-items-center justify-content-center"
            data-bs-toggle="offcanvas" data-bs-target="#searchBox"
            style="width: 56px; height: 56px; padding: 0;">
            <i class="fas fa-search fs-5"></i>
        </button>

        {{-- Shopping Cart Button --}}
        <button type="button" class="btn btn-lg btn-primary rounded-pill shadow-lg mb-3 d-flex align-items-center justify-content-center position-relative"
            data-bs-toggle="offcanvas" data-bs-target="#shoppingCart" style="width: 56px; height: 56px; padding: 0;">
            <i class="fas fa-shopping-cart fs-5"></i>
            @if(Cart::count() > 0)
            <span class="position-absolute badge rounded-circle bg-danger d-flex align-items-center justify-content-center" style="top: -2px; right: -2px; width: 20px; height: 20px; font-size: 11px; font-weight: bold; color: white !important; padding: 0; z-index: 10;">
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
            // Sidebar control script
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarClose = document.getElementById('sidebarClose');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const mainContent = document.getElementById('mainContent');

            function openSidebar() {
                if (sidebar) sidebar.classList.add('show');
                if (sidebarOverlay) sidebarOverlay.classList.add('show');
                if (mainContent && window.innerWidth > 768) {
                    mainContent.classList.add('sidebar-open');
                }
            }

            function closeSidebar() {
                if (sidebar) sidebar.classList.remove('show');
                if (sidebarOverlay) sidebarOverlay.classList.remove('show');
                if (mainContent) mainContent.classList.remove('sidebar-open');
            }

            if (sidebarToggle) sidebarToggle.addEventListener('click', openSidebar);
            if (sidebarClose) sidebarClose.addEventListener('click', closeSidebar);
            if (sidebarOverlay) sidebarOverlay.addEventListener('click', closeSidebar);

            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            console.log('✅ Frontend Layout: Initialized successfully');
        });

        document.addEventListener('DOMContentLoaded', function() {
            const searchBox = document.getElementById('searchBox');
            const btnOpenSearch = document.getElementById('btnOpenSearch');

            if (searchBox && btnOpenSearch) {
                // Logic 1: Khi Off-canvas Search ĐÓNG -> Hiện nút nổi
                searchBox.addEventListener('hidden.bs.offcanvas', function() {
                    btnOpenSearch.classList.remove('d-none');
                    btnOpenSearch.classList.add('d-flex');
                });

                // Logic 2: Khi Off-canvas Search MỞ -> Ẩn nút nổi
                searchBox.addEventListener('shown.bs.offcanvas', function() {
                    btnOpenSearch.classList.add('d-none');
                    btnOpenSearch.classList.remove('d-flex');
                });
            }
        });

        document.querySelectorAll('.dropdown-submenu .dropdown-toggle').forEach(function(element) {
            element.addEventListener('click', function(e) {
                if (window.innerWidth < 992) {
                    e.preventDefault();
                    e.stopPropagation();
                    this.parentNode.classList.toggle('show');
                }
            });
        });

        // Theme switcher functionality
        function toggleTheme() {
            const currentTheme = document.documentElement.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-bs-theme', currentTheme);
            localStorage.setItem('theme', currentTheme);
            if (currentTheme === 'dark') {
                document.body.classList.add('dark-mode');
            } else {
                document.body.classList.remove('dark-mode');
            }
            const themeIcon = document.getElementById('themeIcon');
            if (themeIcon) {
                themeIcon.className = currentTheme === 'dark' ? 'fas fa-sun text-white fs-5' : 'fas fa-moon text-white fs-5';
            }
        }

        // Initialize Theme
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-bs-theme', savedTheme);
            if (savedTheme === 'dark') {
                document.body.classList.add('dark-mode');
            }
            document.addEventListener('DOMContentLoaded', () => {
                const themeIcon = document.getElementById('themeIcon');
                if (themeIcon) {
                    themeIcon.className = savedTheme === 'dark' ? 'fas fa-sun text-white fs-5' : 'fas fa-moon text-white fs-5';
                }
            });
        })();

        function updateSearchAction(value) {
            const form = document.getElementById('globalSearchForm');
            if (form) {
                if (value === 'articles') {
                    form.action = "{{ route('frontend.search.article_results') }}";
                    document.getElementById('searchInputField').placeholder = "Search technical articles & topics...";
                } else {
                    form.action = "{{ route('frontend.search.product_results') }}";
                    document.getElementById('searchInputField').placeholder = "Type IoT product name...";
                }
            }
        }
    </script>

    {{-- Custom JavaScript --}}
    @yield('javascript')
</body>

</html>