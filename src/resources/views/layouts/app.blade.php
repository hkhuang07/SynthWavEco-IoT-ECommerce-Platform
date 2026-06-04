<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SynWavEco') }}</title>

    <link rel="preload" href="{{ asset('public/images/favicon.ico') }}" as="image" type="image/x-icon">
    <link rel="icon" type="image/x-icon" href="{{ asset('public/images/favicon.ico') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/images/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('public/images/favicon.ico') }}">
    <link rel="icon" type="image/jpg" href="{{ asset('public/images/synwaveco-logo') }}" sizes="32x32" />
    <link rel="apple-touch-icon" href="{{ asset('public/images/synwaveco-logo') }}" />

    <link rel="preload" href="{{ asset('public/assets/fonts/inter-variable-latin.woff2') }}" as="font" type="font/woff2" crossorigin />
    <link rel="preload" href="{{ asset('public/assets/icons/cartzilla-icons.woff2') }}" as="font" type="font/woff2" crossorigin />
    <link rel="stylesheet" href="{{ asset('public/assets/icons/cartzilla-icons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/vendor/font-awesome/css/all.min.css') }}">

    <link rel="preload" href="{{ asset('public/images/favicon.ico') }}" as="image" type="image/x-icon">
    <link rel="icon" type="image/x-icon" href="{{ asset('public/images/favicon.ico') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/images/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('public/images/favicon.ico') }}">

    <link rel="icon" type="image/jpg" href="{{ asset('public/images/synwaveco-logo.jpg') }}" sizes="32x32" />
    <link rel="apple-touch-icon" href="{{ asset('public/images/synwaveco-logo.jpg') }}" />
    <link rel="preload" href="{{ asset('public/images/favicon.ico') }}" as="image" type="image/x-icon">
    <link rel="icon" type="image/x-icon" href="{{ asset('public/images/favicon.ico') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/images/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('public/images/favicon.ico') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{{ asset('public/css/layout.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/vendor/font-awesome/css/all.min.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    @yield('styles')

</head>

<body>
    @include('layouts.partials.sidebar')
    @include('layouts.partials.cart-offcanvas')
    @include('layouts.partials.navbar')

    <div id="pageWrapper">
        <main class="main-content" id="mainContent">
            <div class="container-fluid pt-3">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @yield('content')
            </div>
        </main>

        <footer>
            <div class="container py-5">
                <div class="footer-service-intro p-4 mb-5 rounded">
                    <h2 class="mb-4">
                        <i class="fas fa-seedling me-2"></i>{{ config('app.name', 'SynWavEco') }}: Smart IoT Solutions for Agriculture
                    </h2>
                    <p class="lead">
                        {{ config('app.name', 'SynWavEco') }} is an integrated IoT ecosystem for modern agriculture.
                        Our platform features key functionalities like
                        <span class="highlight">Smart Sensors</span>,
                        <span class="highlight">Real-time Monitoring</span>,
                        <span class="highlight">Automated Irrigation</span>,
                        and <span class="highlight">Data Analytics</span>.
                        With comprehensive device management and alert systems, we optimize crop yield and resource efficiency for sustainable farming.
                    </p>
                </div>

                <div class="row g-4 mb-5">
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-column p-4 h-100 rounded">
                            <h3 class="mb-4">
                                <i class="fas fa-headset me-2"></i>Customer Service
                            </h3>
                            <div class="d-flex flex-column gap-1">
                                <a href="#" class="footer-link-item">
                                    <i class="fas fa-question-circle me-2"></i>Help Center
                                </a>
                                <a href="#" class="footer-link-item">
                                    <i class="fas fa-blog me-2"></i>SynWavEco Blog
                                </a>
                                <a href="#" class="footer-link-item">
                                    <i class="fas fa-shopping-cart me-2"></i>How To Buy
                                </a>
                                <a href="#" class="footer-link-item">
                                    <i class="fas fa-microchip me-2"></i>IoT Setup Guide
                                </a>
                                <a href="#" class="footer-link-item">
                                    <i class="fas fa-credit-card me-2"></i>Payment
                                </a>
                                <a href="#" class="footer-link-item">
                                    <i class="fas fa-shipping-fast me-2"></i>Shipping
                                </a>
                                <a href="#" class="footer-link-item">
                                    <i class="fas fa-undo me-2"></i>Return & Refund
                                </a>
                                <a href="#" class="footer-link-item">
                                    <i class="fas fa-phone me-2"></i>Contact Us
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="footer-column p-4 h-100 rounded">
                            <h3 class="mb-4">
                                <i class="fas fa-info-circle me-2"></i>About {{ config('app.name', 'SynWavEco') }}
                            </h3>
                            <div class="d-flex flex-column gap-1 mb-4">
                                <a href="#" class="footer-link-item">
                                    <i class="fas fa-building me-2"></i>About Us
                                </a>
                                <a href="#" class="footer-link-item">
                                    <i class="fas fa-users me-2"></i>Careers
                                </a>
                                <a href="#" class="footer-link-item">
                                    <i class="fas fa-file-contract me-2"></i>Company Policy
                                </a>
                                <a href="#" class="footer-link-item">
                                    <i class="fas fa-newspaper me-2"></i>Media
                                </a>
                            </div>

                            <h3 class="mb-4">
                                <i class="fas fa-share-alt me-2"></i>Follow Us
                            </h3>
                            <div class="d-flex flex-column gap-1">
                                <a href="#" class="footer-link-item">
                                    <i class="fab fa-facebook me-2"></i>Facebook
                                </a>
                                <a href="#" class="footer-link-item">
                                    <i class="fab fa-linkedin me-2"></i>LinkedIn
                                </a>
                                <a href="#" class="footer-link-item">
                                    <i class="fab fa-github me-2"></i>Github
                                </a>
                                <a href="#" class="footer-link-item">
                                    <i class="fab fa-instagram me-2"></i>Instagram
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="footer-column p-4 h-100 rounded">
                            <h3 class="mb-4">
                                <i class="fas fa-credit-card me-2"></i>Payment
                            </h3>
                            <div class="d-flex flex-column gap-1 mb-4">
                                <div class="footer-info-item">
                                    <i class="fab fa-cc-visa me-2"></i>VISA
                                </div>
                                <div class="footer-info-item">
                                    <i class="fas fa-mobile-alt me-2"></i>MoMo
                                </div>
                                <div class="footer-info-item">
                                    <i class="fas fa-mobile-alt me-2"></i>ZaloPay
                                </div>
                                <div class="footer-info-item">
                                    <i class="fas fa-credit-card me-2"></i>Credit Card
                                </div>
                            </div>

                            <h3 class="mb-4">
                                <i class="fas fa-truck me-2"></i>Logistics
                            </h3>
                            <div class="d-flex flex-column gap-1">
                                <div class="footer-info-item">
                                    <i class="fas fa-shipping-fast me-2"></i>SPX
                                </div>
                                <div class="footer-info-item">
                                    <i class="fas fa-shipping-fast me-2"></i>Viettel Post
                                </div>
                                <div class="footer-info-item">
                                    <i class="fas fa-shipping-fast me-2"></i>J&T Express
                                </div>
                                <div class="footer-info-item">
                                    <i class="fas fa-shipping-fast me-2"></i>Grab Express
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="footer-column footer-app-section p-4 h-100 rounded">
                            <h3 class="mb-4">
                                <i class="fas fa-mobile-alt me-2"></i>Download Our App
                            </h3>
                            <div class="mb-4">
                                <div class="footer-qr-placeholder">
                                    <div>
                                        <i class="fas fa-qrcode fa-2x mb-2"></i>
                                        <div class="small">QR Code</div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column align-items-center">
                                <a href="#" class="footer-app-button">
                                    <i class="fab fa-apple me-2"></i>App Store
                                </a>
                                <a href="#" class="footer-app-button">
                                    <i class="fab fa-google-play me-2"></i>Google Play
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="footer-bottom pt-4 text-center">
                    <div class="footer-bottom-links mb-3">
                        <a href="#" class="me-3">Privacy Policy</a>
                        <a href="#" class="me-3">Terms of Service</a>
                        <a href="#" class="me-3">Shipping Policy</a>
                        <a href="#" class="me-3">Return & Refund Policy</a>
                    </div>

                    <div class="footer-company-info">
                        <p class="mb-2">&copy; {{ date('Y') }} {{ config('app.name', 'SynWavEco') }} by Huynh Quoc Huy. All rights reserved.</p>
                        <p class="mb-2">{{ config('app.name', 'SynWavEco') }} Technology Company Limited</p>
                        <p class="mb-0">
                            Address: <span class="footer-highlight">Long Xuyen City, An Giang, VietNam</span> |
                            Tax Code: <span class="footer-highlight">8825719470</span> |
                            Email: <span class="footer-highlight">greentech@gmail.com</span>
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

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

            console.log('✅ App Layout: Initialized successfully');
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
    </script>

    @yield('scripts')
</body>