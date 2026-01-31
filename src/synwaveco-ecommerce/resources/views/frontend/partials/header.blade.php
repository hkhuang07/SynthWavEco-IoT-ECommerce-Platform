{{-- ========================================
   SYNWAVECO FRONTEND HEADER COMPONENT
   Handles Auth Status & Role-Based Navigation
   ======================================== --}}

<header class="sticky-header">
    {{-- Main Navigation Bar --}}
    <nav class="navbar navbar-expand-lg navbar-sticky bg-body border-bottom">
        <div class="container-fluid">
            {{-- Brand Logo --}}
            <a class="navbar-brand fw-bold" href="{{ route('frontend.home') }}">
                <span class="d-none d-sm-flex flex-shrink-0 text-primary me-2">
                    <img src="{{ asset('public/images/synwaveco-logo.jpg') }}"
                        alt="{{ config('app.name', 'SynWavEco') }} Logo"
                        loading="lazy"
                        style="width: 36px; height: 36px; object-fit: contain;">
                </span>
                <span class="fw-bold brand-text">{{ config('app.name', 'SynWavEco') }}</span>
            </a>

            {{-- Mobile Toggle Button --}}
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="fas fa-bars text-primary fs-5"></i>
            </button>

            {{-- Navigation Links --}}
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto gap-2">
                    {{-- HOME --}}
                    <li class="nav-item">
                        <a class="nav-link fw-500 {{ Route::is('frontend.home') ? 'active' : '' }}"
                            href="{{ route('frontend.home') }}">
                            <i class="fas fa-home me-2"></i>Home
                        </a>
                    </li>

                    {{-- PRODUCTS --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-500" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-box me-2"></i>Products
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('frontend.products_categories') }}">
                                    <i class="fas fa-list me-2"></i>By Category
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('frontend.products_manufactures') }}">
                                    <i class="fas fa-industry me-2"></i>By Manufacturer
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('frontend.products') }}">
                                    <i class="fas fa-file-alt me-2"></i>All Products
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- ARTICLES / NEWS --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-500" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-newspaper me-2"></i>Articles
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('frontend.articles_topics') }}">
                                    <i class="fas fa-tag me-2"></i>By Topic
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('frontend.articles_types') }}">
                                    <i class="fas fa-layer-group me-2"></i>By Type
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('frontend.articles') }}">
                                    <i class="fas fa-file-alt me-2"></i>All Articles
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- ABOUT / CONTACT --}}
                    <li class="nav-item">
                        <a class="nav-link fw-500" href="{{ route('frontend.contact') }}">
                            <i class="fas fa-envelope me-2"></i>Contact
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-500" href="{{ route('frontend.recruitment') }}">
                            <i class="fas fa-briefcase me-2"></i>Recruitment
                        </a>
                    </li>
                    {{-- GUEST MENU (Not Authenticated) --}}
                    @guest
                    <li class="nav-item ms-lg-3 border-start-lg ps-lg-3">
                        <a class="nav-link fw-600 text-success" href="{{ route('user.login') }}">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-600 text-primary" href="{{ route('user.register') }}">
                            <i class="fas fa-user-plus me-2"></i>Register
                        </a>
                    </li>

                    {{-- AUTHENTICATED USER MENU --}}
                    @else
                    <li class="nav-item ms-lg-3 border-start-lg ps-lg-3">
                        <a class="nav-link fw-500" href="{{ route('frontend.shoppingcard') }}">
                            <i class="fas fa-shopping-cart me-2"></i>
                            Cart
                            @if(Cart::count() > 0)
                            <span class="badge bg-danger ms-1">{{ Cart::count() }}</span>
                            @endif
                        </a>
                    </li>

                    {{-- USER DROPDOWN --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-600 text-primary" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img id="currentAvatar" src="{{ asset('storage/app/private') }}/{{Auth::user()->avatar}}" alt="Avatar" class="d-flex justify-content-center align-items-center flex-shrink-0 text-primary bg-primary-subtle lh-1 rounded-circle me-3" style="width:2.2rem; height:2.2rem">
                            <span class="badge badge-role ms-2">
                                {{ Auth::user()->name }}
                            </span>

                            <!--@if(Auth::user()->role)
                            <span class="badge badge-role ms-2">
                                <i class="fas fa-shield-alt me-1"></i>{{ Auth::user()->role->name }}
                            </span>
                            @endif-->
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                @php
                                $homeRoute = 'frontend.home';
                                if(Auth::user()->role) {
                                $roleName = Auth::user()->role->name;
                                if($roleName === 'Administrator') $homeRoute = 'administrator.home';
                                elseif($roleName === 'Saler') $homeRoute = 'saler.home';
                                elseif($roleName === 'Shipper') $homeRoute = 'shipper.home';
                                }
                                @endphp
                                <a class="dropdown-item fw-bold text-primary" href="{{ route($homeRoute) }}">
                                    <i class="fas fa-th-large fs-lg opacity-60 me-2"></i>
                                    Go to Dashboard
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('user.profile') }}">
                                    <i class="fas fa-id-card me-2"></i>My Profile
                                </a>
                            </li>
                            @if(Auth::user()->role && Auth::user()->role->name === 'Admin')
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li class="dropdown-header">
                                <i class="fas fa-cog me-2"></i>Administration
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('administrator.home') }}">
                                    <i class="fas fa-tachometer-alt me-2"></i>Admin Dashboard
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('administrator.users') }}">
                                    <i class="fas fa-users me-2"></i>Manage Users
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('administrator.products') }}">
                                    <i class="fas fa-boxes me-2"></i>Manage Products
                                </a>
                            </li>
                            @endif
                            @if(Auth::user()->role && Auth::user()->role->name === 'Saler')
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li class="dropdown-header">
                                <i class="fas fa-chart-bar me-2"></i>Sales
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('saler.home') }}">
                                    <i class="fas fa-tachometer-alt me-2"></i>Saler Dashboard
                                </a>
                            </li>
                            @endif
                            @if(Auth::user()->role && Auth::user()->role->name === 'Shipper')
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li class="dropdown-header">
                                <i class="fas fa-truck me-2"></i>Shipping
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('shipper.home') }}">
                                    <i class="fas fa-tachometer-alt me-2"></i>Shipper Dashboard
                                </a>
                            </li>
                            @endif
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="{{ route('user.logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form-navbar').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </a>
                            </li>

                            <form id="logout-form-navbar" action="{{ route('user.logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </ul>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!--@if(Route::is('frontend.home') || Route::is('frontend.products_categories'))
    <nav class="navbar navbar-expand-lg bg-light border-bottom sticky-lg-top">
        <div class="container-fluid">
            <div class="navbar-nav overflow-auto gap-2" style="flex-wrap: nowrap;">
                <a class="nav-link fw-500 text-primary" href="{{ route('frontend.products_categories') }}">
                    <i class="fas fa-layer-group me-2"></i>All Categories
                </a>
                @php
                $categories = \App\Models\Category::limit(8)->get();
                @endphp
                @forelse($categories ?? [] as $category)
                <a class="nav-link fw-500" href="{{ route('frontend.products.categories', ['categoryname_slug' => $category->slug]) }}">
                    {{ $category->name }}
                </a>
                @empty
                @endforelse
            </div>
        </div>
    </nav>
    @endif-->
</header>

{{-- Additional Styles for Header --}}
<style>
    .navbar-sticky {
        position: sticky !important;
        top: 0 !important;
        z-index: 9999 !important;
        box-shadow: 0 2px 10px rgba(0, 139, 69, 0.1) !important;
    }

    .sticky-lg-top {
        position: sticky !important;
        top: 60px !important;
        z-index: 9998 !important;
    }

    .border-start-lg {
        border-left: 1px solid rgba(0, 139, 69, 0.2) !important;
    }

    .fw-500 {
        font-weight: 500;
    }

    .fw-600 {
        font-weight: 600;
    }

    .text-success {
        color: #008B45 !important;
    }

    .text-primary {
        color: #008B45 !important;
    }

    .badge-role {
        background-color: #1E90FF !important;
        color: white !important;
        padding: 0.25rem 0.5rem;
        border-radius: 12px;
        font-size: 0.75rem;
        margin-left: 0.25rem;
        font-weight: 600;
    }

    /* Mobile Responsive */
    @media (max-width: 992px) {
        .border-start-lg {
            border-left: none !important;
            margin-top: 0.5rem;
        }

        .navbar-nav {
            gap: 0.5rem !important;
        }

        .nav-link {
            padding: 0.5rem !important;
        }
    }
</style>