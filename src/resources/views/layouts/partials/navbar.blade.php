<nav class="navbar navbar-expand-lg navbar-custom" id="mainNavbar">
    <div class="container-fluid">
        <!-- Sidebar Toggle Hamburger -->
        <button class="sidebar-toggle btn me-2" id="sidebarToggle" type="button">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Brand Logo & Brand Name Image in a unified white pill badge -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('frontend.home') }}">
            <div class="d-flex align-items-center bg-white rounded-pill px-3 py-1 shadow-sm border border-light-subtle">
                <img src="{{ asset('public/images/synwaveco-logo.jpg') }}" alt="Logo" style="height: 30px; width: 30px; object-fit: contain; margin-right: 8px;">
                <img src="{{ asset('public/images/logoname.jpg') }}" alt="{{ config('app.name', 'SynWavEco') }}" style="height: 20px; object-fit: contain;">
            </div>
        </a>

        <!-- Mobile Toggle for Navbar Menu -->
        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <i class="fas fa-bars text-white"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <!-- General Navigation Links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-3 gap-2">
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('frontend.home') ? 'active' : '' }}" href="{{ route('frontend.home') }}">
                        <i class="fas fa-home me-1"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('frontend.products') ? 'active' : '' }}" href="{{ route('frontend.products') }}">
                        <i class="fas fa-box me-1"></i> Products
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('frontend.articles') ? 'active' : '' }}" href="{{ route('frontend.articles') }}">
                        <i class="fas fa-newspaper me-1"></i> Articles
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('frontend.contact') ? 'active' : '' }}" href="{{ route('frontend.contact') }}">
                        <i class="fas fa-envelope me-1"></i> Contact
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('frontend.recruitment') ? 'active' : '' }}" href="{{ route('frontend.recruitment') }}">
                        <i class="fas fa-briefcase me-1"></i> Recruitment
                    </a>
                </li>
            </ul>

            <!-- Right Controls: Shopping Cart, Theme Switcher, Account -->
            <ul class="navbar-nav ms-auto align-items-center gap-3">
                <!-- Shopping Cart Icon/Button -->
                <li class="nav-item">
                    <button type="button" class="btn btn-outline-info border-0 position-relative" data-bs-toggle="offcanvas" data-bs-target="#shoppingCart" style="width: 42px; height: 42px; display: flex; align-items: center; justify-content: center; padding: 0;">
                        <i class="fas fa-shopping-cart fs-4 text-white"></i>
                        @if(Cart::count() > 0)
                            <span class="position-absolute badge rounded-circle bg-danger d-flex align-items-center justify-content-center" id="cartCountBadge" style="top: -2px; right: -2px; width: 20px; height: 20px; font-size: 11px; font-weight: bold; color: white !important; padding: 0; z-index: 10;">
                                {{ Cart::count() }}
                            </span>
                        @endif
                    </button>
                </li>

                <!-- Dark/Light Theme Switcher Toggle -->
                <li class="nav-item">
                    <button class="btn btn-outline-info border-0 p-2" onclick="toggleTheme()" title="Toggle Dark/Light Mode" type="button">
                        <i id="themeIcon" class="fas fa-moon text-white fs-5"></i>
                    </button>
                </li>

                <!-- Profile Dropdown Menu -->
                @guest
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle fs-5 me-1"></i> Account
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('user.login') }}">
                                    <i class="fas fa-sign-in-alt me-2"></i> Log In
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('user.register') }}">
                                    <i class="fas fa-user-plus me-2"></i> Register
                                </a>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center py-1 pe-0" href="#" role="button" data-bs-toggle="dropdown">
                            @if(Auth::user()->avatar)
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="rounded-circle me-2" style="width: 32px; height: 32px; object-fit: cover;">
                            @else
                                <i class="fas fa-user-circle text-white fs-5 me-2"></i>
                            @endif
                            <span class="d-none d-md-inline text-white">{{ Auth::user()->name }}</span>
                            <span class="badge badge-role ms-2">
                                {{ Auth::user()->role ? Auth::user()->role->name : 'Customer' }}
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @php
                                $dashboardRoute = 'user.home';
                                if(Auth::user()->role) {
                                    $roleName = strtolower(Auth::user()->role->name);
                                    if($roleName === 'administrator' || $roleName === 'admin') $dashboardRoute = 'administrator.home';
                                    elseif($roleName === 'saler' || $roleName === 'sales') $dashboardRoute = 'saler.home';
                                    elseif($roleName === 'shipper') $dashboardRoute = 'shipper.home';
                                }
                            @endphp
                            <li>
                                <a class="dropdown-item fw-bold" href="{{ route($dashboardRoute) }}">
                                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('user.profile') }}">
                                    <i class="fas fa-user me-2"></i> My Profile
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="{{ route('user.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-navbar-partial').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </a>
                                <form id="logout-form-navbar-partial" action="{{ route('user.logout') }}" method="POST" class="d-none">@csrf</form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
