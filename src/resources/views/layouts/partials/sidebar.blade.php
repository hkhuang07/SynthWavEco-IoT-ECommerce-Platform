<div class="sidebar-overlay" id="sidebarOverlay"></div>

<nav class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h5 class="d-flex align-items-center justify-content-between w-100">
            <span class="d-flex align-items-center">
                <div class="d-flex align-items-center bg-white rounded-pill px-2 py-1 shadow-sm border border-light-subtle">
                    <img src="{{ asset('public/images/synwaveco-logo.jpg') }}" alt="Logo" style="height: 20px; width: 40px; object-fit: contain; margin-right: 4px;">
                    <img src="{{ asset('public/images/logoname.jpg') }}" alt="{{ config('app.name', 'SynWavEco') }}" style="height: 14px; object-fit: contain;">
                </div>
            </span>
            <button class="sidebar-close" id="sidebarClose">
                <i class="fas fa-times"></i>
            </button>
        </h5>
    </div>

    <ul class="sidebar-nav">
        @guest
            <li>
                <h6 class="sidebar-section-title">Navigation</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('frontend.home') }}">
                    <i class="fas fa-home"></i> Home
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('frontend.products') }}">
                    <i class="fas fa-box"></i> Products
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('frontend.articles') }}">
                    <i class="fas fa-newspaper"></i> Articles
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('frontend.contact') }}">
                    <i class="fas fa-envelope"></i> Contact
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('frontend.recruitment') }}">
                    <i class="fas fa-briefcase"></i> Recruitment
                </a>
            </li>
            <li>
                <h6 class="sidebar-section-title">Account</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link text-success" href="{{ route('user.login') }}">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-primary" href="{{ route('user.register') }}">
                    <i class="fas fa-user-plus"></i> Register
                </a>
            </li>
        @else
            {{-- User info block in Sidebar --}}
            <li class="nav-item px-3 py-2 border-bottom">
                <div class="d-flex align-items-center">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="rounded-circle me-2" style="width: 40px; height: 40px; object-fit: cover;">
                    @else
                        <i class="fas fa-user-circle text-white fs-3 me-2"></i>
                    @endif
                    <div>
                        <div class="fw-bold text-white small">{{ Auth::user()->name }}</div>
                        <span class="badge badge-role mt-1">
                            {{ Auth::user()->role ? Auth::user()->role->name : 'Customer' }}
                        </span>
                    </div>
                </div>
            </li>

            {{-- Dynamic Links based on role --}}
            @php
                $role = Auth::user()->role ? strtolower(Auth::user()->role->name) : 'users';
            @endphp

            @if($role === 'administrator' || $role === 'admin')
                <li>
                    <h6 class="sidebar-section-title">Admin Controls</h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('administrator.home') }}">
                        <i class="fas fa-tachometer-alt"></i> Admin Dashboard
                    </a>
                </li>
                
                {{-- Users & Roles --}}
                <li class="nav-item">
                    <button class="sidebar-dropdown collapsed" data-bs-target="#sidebarUsers" data-bs-toggle="collapse" type="button">
                        <i class="fas fa-users-cog"></i> Users & Roles
                        <i class="fas fa-chevron-down dropdown-icon"></i>
                    </button>
                    <div class="collapse sidebar-submenu" id="sidebarUsers">
                        <a class="nav-link" href="{{ route('administrator.users') }}">
                            <i class="fas fa-users"></i> Users
                        </a>
                        <a class="nav-link" href="{{ route('administrator.roles') }}">
                            <i class="fas fa-user-shield"></i> Roles
                        </a>
                    </div>
                </li>

                {{-- Categories & Manufacturers --}}
                <li class="nav-item">
                    <button class="sidebar-dropdown collapsed" data-bs-target="#sidebarCatalog" data-bs-toggle="collapse" type="button">
                        <i class="fas fa-sitemap"></i> Catalog Info
                        <i class="fas fa-chevron-down dropdown-icon"></i>
                    </button>
                    <div class="collapse sidebar-submenu" id="sidebarCatalog">
                        <a class="nav-link" href="{{ route('administrator.categories') }}">
                            <i class="fas fa-list"></i> Categories
                        </a>
                        <a class="nav-link" href="{{ route('administrator.manufacturers') }}">
                            <i class="fas fa-copyright"></i> Manufacturers
                        </a>
                    </div>
                </li>

                {{-- Content / Articles --}}
                <li class="nav-item">
                    <button class="sidebar-dropdown collapsed" data-bs-target="#sidebarContent" data-bs-toggle="collapse" type="button">
                        <i class="fas fa-newspaper"></i> Articles & Tags
                        <i class="fas fa-chevron-down dropdown-icon"></i>
                    </button>
                    <div class="collapse sidebar-submenu" id="sidebarContent">
                        <a class="nav-link" href="{{ route('administrator.topics') }}">
                            <i class="fas fa-tags"></i> Topics
                        </a>
                        <a class="nav-link" href="{{ route('administrator.article_types') }}">
                            <i class="fas fa-layer-group"></i> Article Types
                        </a>
                        <a class="nav-link" href="{{ route('administrator.article_statuses') }}">
                            <i class="fas fa-toggle-on"></i> Article Status
                        </a>
                        <a class="nav-link" href="{{ route('administrator.articles') }}">
                            <i class="fas fa-file-alt"></i> Articles
                        </a>
                        <a class="nav-link" href="{{ route('administrator.comments') }}">
                            <i class="fas fa-comments"></i> Comments
                        </a>
                    </div>
                </li>

                {{-- Product Management --}}
                <li class="nav-item">
                    <button class="sidebar-dropdown collapsed" data-bs-target="#sidebarProducts" data-bs-toggle="collapse" type="button">
                        <i class="fas fa-box"></i> Products
                        <i class="fas fa-chevron-down dropdown-icon"></i>
                    </button>
                    <div class="collapse sidebar-submenu" id="sidebarProducts">
                        <a class="nav-link" href="{{ route('administrator.products') }}">
                            <i class="fas fa-cube"></i> Manage Products
                        </a>
                    </div>
                </li>

                {{-- Orders --}}
                <li class="nav-item">
                    <button class="sidebar-dropdown collapsed" data-bs-target="#sidebarOrders" data-bs-toggle="collapse" type="button">
                        <i class="fas fa-file-invoice"></i> Order Management
                        <i class="fas fa-chevron-down dropdown-icon"></i>
                    </button>
                    <div class="collapse sidebar-submenu" id="sidebarOrders">
                        <a class="nav-link" href="{{ route('administrator.orders') }}">
                            <i class="fas fa-shopping-cart"></i> All Orders
                        </a>
                        <a class="nav-link" href="{{ route('administrator.order_statuses') }}">
                            <i class="fas fa-list-check"></i> Order Status
                        </a>
                    </div>
                </li>

                {{-- IoT Management --}}
                <li class="nav-item">
                    <button class="sidebar-dropdown collapsed" data-bs-target="#sidebarIoT" data-bs-toggle="collapse" type="button">
                        <i class="fas fa-microchip"></i> IoT Systems
                        <i class="fas fa-chevron-down dropdown-icon"></i>
                    </button>
                    <div class="collapse sidebar-submenu" id="sidebarIoT">
                        <a class="nav-link" href="{{ route('administrator.iot_devices') }}">
                            <i class="fas fa-network-wired"></i> IoT Devices
                        </a>
                        <a class="nav-link" href="{{ route('administrator.device_metrics') }}">
                            <i class="fas fa-chart-line"></i> Device Metrics
                        </a>
                        <a class="nav-link" href="{{ route('administrator.alert_thresholds') }}">
                            <i class="fas fa-exclamation-triangle"></i> Alert Thresholds
                        </a>
                    </div>
                </li>

            @elseif($role === 'saler' || $role === 'sales')
                <li>
                    <h6 class="sidebar-section-title">Sales Desk</h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('saler.home') }}">
                        <i class="fas fa-tachometer-alt"></i> Saler Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('administrator.products') }}">
                        <i class="fas fa-cube"></i> View Products
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('administrator.orders') }}">
                        <i class="fas fa-shopping-cart"></i> Orders
                    </a>
                </li>

            @elseif($role === 'shipper')
                <li>
                    <h6 class="sidebar-section-title">Shipping Desk</h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('shipper.home') }}">
                        <i class="fas fa-shipping-fast"></i> Shipper Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('administrator.orders') }}">
                        <i class="fas fa-route"></i> Deliveries
                    </a>
                </li>

            @else
                {{-- Standard User / Customer --}}
                <li>
                    <h6 class="sidebar-section-title">Member Menu</h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.home') }}">
                        <i class="fas fa-user-circle"></i> User Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.profile') }}">
                        <i class="fas fa-id-card"></i> My Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.order') }}">
                        <i class="fas fa-box-open"></i> My Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.change-password') }}">
                        <i class="fas fa-key"></i> Change Password
                    </a>
                </li>
            @endif

            {{-- General Site Links for Logged-In Users too --}}
            <li>
                <h6 class="sidebar-section-title">Quick Links</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('frontend.home') }}">
                    <i class="fas fa-home"></i> Go to Homepage
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('frontend.products') }}">
                    <i class="fas fa-box"></i> Shop Products
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('frontend.articles') }}">
                    <i class="fas fa-newspaper"></i> Articles & News
                </a>
            </li>

            <li>
                <h6 class="sidebar-section-title">System Actions</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link text-danger" href="{{ route('user.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar-partial').submit();">
                    <i class="fas fa-sign-out-alt"></i> Log Out
                </a>
                <form id="logout-form-sidebar-partial" action="{{ route('user.logout') }}" method="POST" class="d-none">@csrf</form>
            </li>
        @endguest
    </ul>
</nav>
